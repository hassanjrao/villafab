param(
    [Parameter(Mandatory=$true)][ValidateSet('Open','OpenCreator','Inspect','Invoke','Fill','Upload','Check','Keys','Read','Url','Screenshot','FillPost','FillAlt','Finalize','Verify','Publish','VerifyPublished','CheckSavedAfterReload','Topics','SelectTopic','GoPublished','UpdatePublished','TypeFocusedDescription')][string]$Action,
    [long]$WindowHandle=4394230,
    [string]$Name,
    [string]$Text,
    [ValidateSet('005','006','007')][string]$PinId='005',
    [string]$BatchFile='D:\laravel\villafab-laravel\docs\pinterest\batch-2026-10-20.json',
    [switch]$PublicAiBadge,
    [ValidateSet('On','Off')][string]$State='On',
    [int]$WaitMilliseconds=300
)
$ErrorActionPreference='Stop'
Add-Type -AssemblyName UIAutomationClient
Add-Type -AssemblyName UIAutomationTypes
Add-Type -AssemblyName System.Windows.Forms
Add-Type -AssemblyName System.Drawing
Add-Type @'
using System;using System.Text;using System.Runtime.InteropServices;
public class PinBatchDesktop {
 public delegate bool EnumCallback(IntPtr window,IntPtr parameter);
 [StructLayout(LayoutKind.Sequential)] public struct RECT {public int Left,Top,Right,Bottom;}
 [DllImport("user32.dll")]public static extern bool SetForegroundWindow(IntPtr window);
 [DllImport("user32.dll")]public static extern IntPtr GetForegroundWindow();
 [DllImport("user32.dll")]public static extern IntPtr GetWindow(IntPtr window,uint command);
 [DllImport("user32.dll")]public static extern IntPtr GetLastActivePopup(IntPtr window);
 [DllImport("user32.dll")]public static extern bool EnumWindows(EnumCallback callback,IntPtr parameter);
 [DllImport("user32.dll")]public static extern bool IsWindowVisible(IntPtr window);
 [DllImport("user32.dll",CharSet=CharSet.Unicode)]public static extern int GetWindowText(IntPtr window,StringBuilder text,int count);
 [DllImport("user32.dll")]public static extern void keybd_event(byte key,byte scan,uint flags,UIntPtr info);
 [DllImport("user32.dll")]public static extern bool SetCursorPos(int x,int y);
 [DllImport("user32.dll")]public static extern void mouse_event(uint flags,uint dx,uint dy,uint data,UIntPtr info);
 [DllImport("user32.dll")]public static extern bool SetProcessDPIAware();
 [DllImport("user32.dll")]public static extern bool GetWindowRect(IntPtr window,out RECT rect);
}
'@
[PinBatchDesktop]::SetProcessDPIAware()|Out-Null
$pinWindow=[IntPtr]$WindowHandle
$pinRoot=[System.Windows.Automation.AutomationElement]::FromHandle($pinWindow)
function Find-Name($Root,[string]$ControlName,$Type=$null) {
    $pinCondition=New-Object System.Windows.Automation.PropertyCondition([System.Windows.Automation.AutomationElement]::NameProperty,$ControlName)
    if($Type){$pinCondition=New-Object System.Windows.Automation.AndCondition($pinCondition,(New-Object System.Windows.Automation.PropertyCondition([System.Windows.Automation.AutomationElement]::ControlTypeProperty,$Type)))}
    return $Root.FindFirst([System.Windows.Automation.TreeScope]::Descendants,$pinCondition)
}
function Get-PinUrl {
    $pinAddress=Find-Name $pinRoot 'Address and search bar'
    if(-not $pinAddress){throw 'Chrome address bar is unavailable.'}
    return $pinAddress.GetCurrentPattern([System.Windows.Automation.ValuePattern]::Pattern).Current.Value
}
function Assert-Pinterest {
    if((Get-PinUrl) -notmatch '^(https?://)?(www\.)?pinterest\.com(?:/|$)'){throw 'Pinterest is not the active tab; no page operation was performed.'}
}
function Get-PinDocument {
    return $pinRoot.FindFirst([System.Windows.Automation.TreeScope]::Descendants,(New-Object System.Windows.Automation.PropertyCondition([System.Windows.Automation.AutomationElement]::ControlTypeProperty,[System.Windows.Automation.ControlType]::Document)))
}
function Focus-Pinterest {
    foreach($pinModifier in @(0x5B,0x5C,0x10,0x11,0x12,0xA0,0xA1,0xA2,0xA3,0xA4,0xA5)){[PinBatchDesktop]::keybd_event([byte]$pinModifier,0,2,[UIntPtr]::Zero)}
    if($Action -eq 'Upload'){
        $pinOwnedDialogs=[System.Collections.Generic.List[IntPtr]]::new()
        $pinDialogCallback=[PinBatchDesktop+EnumCallback]{param($pinDialogHandle,$pinDialogParameter)
            if([PinBatchDesktop]::IsWindowVisible($pinDialogHandle) -and [PinBatchDesktop]::GetWindow($pinDialogHandle,4) -eq $pinWindow){
                $pinDialogTitle=[System.Text.StringBuilder]::new(512)
                [PinBatchDesktop]::GetWindowText($pinDialogHandle,$pinDialogTitle,512)|Out-Null
                if($pinDialogTitle.ToString() -eq 'Open'){$pinOwnedDialogs.Add($pinDialogHandle)}
            }
            return $true
        }
        [PinBatchDesktop]::EnumWindows($pinDialogCallback,[IntPtr]::Zero)|Out-Null
        if($pinOwnedDialogs.Count -eq 1){
            $pinPopup=$pinOwnedDialogs[0]
            [PinBatchDesktop]::SetForegroundWindow($pinPopup)|Out-Null
            (New-Object -ComObject WScript.Shell).AppActivate('Open')|Out-Null
            Start-Sleep -Milliseconds 150
            if([PinBatchDesktop]::GetForegroundWindow() -eq $pinPopup){return $pinPopup}
            throw 'The Pinterest file picker could not be focused.'
        }
    }
    [PinBatchDesktop]::SetForegroundWindow($pinWindow)|Out-Null
    $pinTitle=[System.Text.StringBuilder]::new(1024)
    [PinBatchDesktop]::GetWindowText($pinWindow,$pinTitle,1024)|Out-Null
    (New-Object -ComObject WScript.Shell).AppActivate($pinTitle.ToString())|Out-Null
    Start-Sleep -Milliseconds 150
    $pinForeground=[PinBatchDesktop]::GetForegroundWindow()
    if($pinForeground -ne $pinWindow -and -not($Action -eq 'Upload' -and [PinBatchDesktop]::GetWindow($pinForeground,4) -eq $pinWindow)){throw 'The selected Pinterest window could not be focused; no input was sent.'}
    return $pinForeground
}
function Send-PinLiteral([string]$Value){
    $pinKeys=($Value.ToCharArray()|ForEach-Object{if('+^%~(){}[]'.Contains([string]$_)){'{'+$_+'}'}else{[string]$_}})-join ''
    [System.Windows.Forms.SendKeys]::SendWait($pinKeys)
}
function Invoke-PinElement($Element){
    if(-not $Element){throw 'The observed Pinterest control was not found.'}
    $pinPattern=$null
    if($Element.TryGetCurrentPattern([System.Windows.Automation.InvokePattern]::Pattern,[ref]$pinPattern)){$pinPattern.Invoke();return}
    $pinPattern=$null
    if($Element.TryGetCurrentPattern([System.Windows.Automation.ExpandCollapsePattern]::Pattern,[ref]$pinPattern)){$pinPattern.Expand();return}
    if($Element.Current.IsOffscreen){throw 'The observed control is offscreen.'}
    Focus-Pinterest|Out-Null
    $pinBounds=$Element.Current.BoundingRectangle
    [PinBatchDesktop]::SetCursorPos([int]($pinBounds.X+$pinBounds.Width/2),[int]($pinBounds.Y+$pinBounds.Height/2))|Out-Null
    [PinBatchDesktop]::mouse_event(2,0,0,0,[UIntPtr]::Zero)
    [PinBatchDesktop]::mouse_event(4,0,0,0,[UIntPtr]::Zero)
}
function Get-Post {
    $pinBatchFile=$BatchFile
    $pinBatch=Get-Content -LiteralPath $pinBatchFile -Raw -Encoding UTF8|ConvertFrom-Json
    $pinPost=$pinBatch.posts|Where-Object{$_.id -eq $PinId}
    if(-not $pinPost -or $pinPost.title.Length -gt 100 -or $pinPost.description.Length -lt 100 -or $pinPost.description.Length -gt 500 -or $pinPost.destination -notmatch ('utm_content=pin_'+$PinId+'$')){throw 'Invalid posting metadata.'}
    return $pinPost
}
function Set-PinField([string]$FieldName,[string]$Value){
    Focus-Pinterest|Out-Null
    $pinField=Find-Name $pinRoot $FieldName ([System.Windows.Automation.ControlType]::Edit)
    if(-not $pinField){$pinField=Find-Name $pinRoot $FieldName ([System.Windows.Automation.ControlType]::ComboBox)}
    if(-not $pinField){throw 'The observed pin text field was not found.'}
    $pinScrollPattern=$null
    if($pinField.TryGetCurrentPattern([System.Windows.Automation.ScrollItemPattern]::Pattern,[ref]$pinScrollPattern)){$pinScrollPattern.ScrollIntoView()}
    $pinField.SetFocus()
    if($FieldName -in @('Title','Link','Alt Text')){
        $pinField.GetCurrentPattern([System.Windows.Automation.ValuePattern]::Pattern).SetValue($Value)
    }else{
        [System.Windows.Forms.SendKeys]::SendWait('^a')
        Send-PinLiteral $Value
    }
    if($FieldName -notmatch '^Tagged topics') {[System.Windows.Forms.SendKeys]::SendWait('{TAB}')}
}
function Get-PinField($Root,[string]$FieldName){
    $pinField=Find-Name $Root $FieldName ([System.Windows.Automation.ControlType]::Edit)
    if(-not $pinField){$pinField=Find-Name $Root $FieldName ([System.Windows.Automation.ControlType]::ComboBox)}
    if(-not $pinField){throw ('The '+$FieldName+' field was not found.')}
    return $pinField.GetCurrentPattern([System.Windows.Automation.ValuePattern]::Pattern).Current.Value
}
function Assert-PinDraft {
    $pinPost=Get-Post
    if($pinPost.published_url){throw 'This pin already has a published URL; a duplicate publication is blocked.'}
    if((Get-PinField $pinRoot 'Title') -ne $pinPost.title){throw 'Title does not match.'}
    if((Get-PinField $pinRoot 'Describe your Pin') -ne $pinPost.description){throw 'Description does not match.'}
    if((Get-PinField $pinRoot 'Link') -ne $pinPost.destination){throw 'Destination does not match.'}
    if((Get-PinField $pinRoot 'Alt Text') -ne $pinPost.alt_text){throw 'Alt text does not match.'}
    $pinBoard=Find-Name $pinRoot ('Board '+$pinPost.board+' Open dropdown') ([System.Windows.Automation.ControlType]::Button)
    if(-not $pinBoard){$pinBoard=Find-Name $pinRoot ('Board '+$pinPost.board) ([System.Windows.Automation.ControlType]::Button)}
    if(-not $pinBoard){throw 'The approved existing public board is not selected.'}
    foreach($pinSetting in @(@('Publish at a later date','Off'),@('Mark as AI-Modified Content that was made completely or partly with AI','Off'),@('This Pin includes an AI-generated person','Off'))){
        $pinCheckbox=Find-Name $pinRoot $pinSetting[0] ([System.Windows.Automation.ControlType]::CheckBox)
        if($pinCheckbox.GetCurrentPattern([System.Windows.Automation.TogglePattern]::Pattern).Current.ToggleState.ToString() -ne $pinSetting[1]){throw ('Incorrect setting: '+$pinSetting[0])}
    }
}
function Wait-PinElement($Root,[string]$ControlName,$Type=$null){
    $pinWaitElement=$null
    for($pinWaitIndex=0;$pinWaitIndex -lt 32 -and -not $pinWaitElement;$pinWaitIndex++){$pinWaitElement=Find-Name $Root $ControlName $Type;if(-not $pinWaitElement){Start-Sleep -Milliseconds 250}}
    if(-not $pinWaitElement){throw ('The '+$ControlName+' control did not become available.')}
    return $pinWaitElement
}
function Open-PinEditor {
    $pinExistingEditor=Find-Name $pinRoot 'Edit Pin details'
    if($pinExistingEditor){return $pinExistingEditor}
    Focus-Pinterest|Out-Null
    $pinViewPanel=Wait-PinElement $pinRoot 'Closeup content container'
    Invoke-PinElement (Wait-PinElement $pinViewPanel 'More actions' ([System.Windows.Automation.ControlType]::Button))
    Invoke-PinElement (Wait-PinElement $pinRoot 'Edit Pin' ([System.Windows.Automation.ControlType]::MenuItem))
    return (Wait-PinElement $pinRoot 'Edit Pin details')
}
if($Action -ne 'Open'){Assert-Pinterest}
switch($Action){
    'OpenCreator' {
        $pinPost=Get-Post
        if($pinPost.published_url){throw 'This pin already has a published URL; duplicate publication blocked.'}
        if((Get-PinUrl) -match '/pin-creation-tool/'){throw 'An existing creation draft is open; finish it before opening another.'}
        Focus-Pinterest|Out-Null
        $pinAddress=Find-Name $pinRoot 'Address and search bar'
        $pinAddress.GetCurrentPattern([System.Windows.Automation.ValuePattern]::Pattern).SetValue('https://www.pinterest.com/pin-creation-tool/')
        $pinAddress.SetFocus()
        [System.Windows.Forms.SendKeys]::SendWait('{ENTER}')
    }
    'CheckSavedAfterReload' {
        $pinPost=Get-Post
        if((Get-PinUrl) -notlike ('*'+([Uri]$pinPost.published_url).AbsolutePath)){throw 'The expected published Pin is not open.'}
        foreach($pinFieldCheck in @(@('Title',$pinPost.title),@('Write a description for your Pin',$pinPost.description),@('Link',$pinPost.destination))){
            if((Get-PinField $pinRoot $pinFieldCheck[0]) -ne $pinFieldCheck[1]){throw ('Saved '+$pinFieldCheck[0]+' differs from prepared copy.')}
        }
        $pinAiCheckbox=Find-Name $pinRoot 'Mark as AI-Modified Content that was made completely or partly with AI' ([System.Windows.Automation.ControlType]::CheckBox)
        if($pinAiCheckbox.GetCurrentPattern([System.Windows.Automation.TogglePattern]::Pattern).Current.ToggleState.ToString() -ne 'Off'){throw 'Manual AI disclosure is not Off.'}
        $pinBatch=Get-Content -LiteralPath $BatchFile -Raw -Encoding UTF8|ConvertFrom-Json
        $pinRecord=$pinBatch.posts|Where-Object{$_.id -eq $PinId}
        $pinRecord.verified=$true
        $pinRecord.manual_ai_disclosure=$false
        $pinRecord.tag_update_status='verified'
        $pinRecord|Add-Member -NotePropertyName public_ai_label_present -NotePropertyValue ([bool]$PublicAiBadge) -Force
        $pinRecord|Add-Member -NotePropertyName verification_date -NotePropertyValue '2026-10-20' -Force
        $pinRecord|Add-Member -NotePropertyName verification_fields -NotePropertyValue @('title','description','destination','manual_ai_disclosure') -Force
        [IO.File]::WriteAllText($BatchFile,($pinBatch|ConvertTo-Json -Depth 12),[System.Text.UTF8Encoding]::new($false))
        [PSCustomObject]@{Pin=$PinId;VerifiedAfterReload=$true;Description=$pinPost.description;ManualAiDisclosure='Off';PublicAiLabelPresent=[bool]$PublicAiBadge}|ConvertTo-Json -Compress
    }
    'TypeFocusedDescription' {
        $pinPost=Get-Post
        $pinExpectedPath=([Uri]$pinPost.published_url).AbsolutePath
        if((Get-PinUrl) -notlike ('*'+$pinExpectedPath)){throw 'The selected published pin is not active.'}
        Focus-Pinterest|Out-Null
        [System.Windows.Forms.SendKeys]::SendWait('^a')
        Send-PinLiteral $pinPost.description
        [System.Windows.Forms.SendKeys]::SendWait('{TAB}')
    }
    'Open' {
        $pinProfile=$pinRoot.FindFirst([System.Windows.Automation.TreeScope]::Descendants,(New-Object System.Windows.Automation.PropertyCondition([System.Windows.Automation.AutomationElement]::AutomationIdProperty,'view_1018')))
        if($pinProfile.Current.Name -ne 'Hassan'){throw 'The previously confirmed Chrome profile was not selected.'}
        Focus-Pinterest|Out-Null
        Invoke-PinElement (Find-Name $pinRoot 'New Tab' ([System.Windows.Automation.ControlType]::Button))
        Start-Sleep -Milliseconds 300
        $pinAddress=Find-Name $pinRoot 'Address and search bar'
        $pinAddress.GetCurrentPattern([System.Windows.Automation.ValuePattern]::Pattern).SetValue('https://www.pinterest.com/pin-creation-tool/')
        $pinAddress.SetFocus()
        [System.Windows.Forms.SendKeys]::SendWait('{ENTER}')
    }
    'Invoke' {
        if($Name -match '(?i)^create board$|^publish$|delete|remove'){throw 'Use the verified publication action; this batch cannot create boards, delete or remove content.'}
        Focus-Pinterest|Out-Null
        $pinTarget=Find-Name $pinRoot $Name ([System.Windows.Automation.ControlType]::Button)
        if(-not $pinTarget){$pinTarget=Find-Name $pinRoot $Name ([System.Windows.Automation.ControlType]::Hyperlink)}
        if(-not $pinTarget){$pinTarget=Find-Name $pinRoot $Name ([System.Windows.Automation.ControlType]::MenuItem)}
        Invoke-PinElement $pinTarget
    }
    'Fill' {
        Set-PinField $Name $Text
    }
    'Upload' {
        $pinForeground=Focus-Pinterest
        $pinDialog=[System.Windows.Automation.AutomationElement]::FromHandle($pinForeground)
        if($pinDialog.Current.Name -ne 'Open' -or [PinBatchDesktop]::GetWindow($pinForeground,4) -ne $pinWindow){throw 'Pinterest file picker is not open.'}
        $pinImage=Join-Path (Split-Path $PSScriptRoot -Parent) ('docs\pinterest\samples\pin-'+$PinId+'.png')
        if(-not(Test-Path -LiteralPath $pinImage)){throw 'The assigned new pin image does not exist.'}
        [System.Windows.Forms.SendKeys]::SendWait('%n')
        [System.Windows.Forms.SendKeys]::SendWait('^a')
        Send-PinLiteral $pinImage
        [System.Windows.Forms.SendKeys]::SendWait('{ENTER}')
    }
    'Check' {
        $pinToggleElement=Find-Name $pinRoot $Name ([System.Windows.Automation.ControlType]::CheckBox)
        if(-not $pinToggleElement){throw 'The observed checkbox was not found.'}
        $pinToggle=$pinToggleElement.GetCurrentPattern([System.Windows.Automation.TogglePattern]::Pattern)
        if($pinToggle.Current.ToggleState.ToString() -ne $State){$pinToggle.Toggle()}
    }
    'GoPublished' {
        $pinPost=Get-Post
        if(-not $pinPost.published_url -or $pinPost.published_url -notmatch '^https://www\.pinterest\.com/pin/[0-9]+/$'){throw 'No verified published URL is recorded for this pin.'}
        if((Get-PinUrl) -match '/pin-creation-tool/'){throw 'Finish the current draft before leaving the editor.'}
        Focus-Pinterest|Out-Null
        $pinAddress=Find-Name $pinRoot 'Address and search bar'
        $pinAddress.GetCurrentPattern([System.Windows.Automation.ValuePattern]::Pattern).SetValue($pinPost.published_url)
        $pinAddress.SetFocus()
        [System.Windows.Forms.SendKeys]::SendWait('{ENTER}')
    }
    'UpdatePublished' {
        $pinPost=Get-Post
        $pinExpectedPath=([Uri]$pinPost.published_url).AbsolutePath
        if((Get-PinUrl) -notlike ('*'+$pinExpectedPath)){throw 'The selected published pin is not active.'}
        $pinEditDialog=Open-PinEditor
        Set-PinField 'Write a description for your Pin' $pinPost.description
        if((Get-PinField $pinEditDialog 'Write a description for your Pin') -ne $pinPost.description){throw 'The hashtagged description did not enter correctly; nothing was saved.'}
        $pinAiCheckbox=Find-Name $pinEditDialog 'Mark as AI-Modified Content that was made completely or partly with AI' ([System.Windows.Automation.ControlType]::CheckBox)
        $pinAiToggle=$pinAiCheckbox.GetCurrentPattern([System.Windows.Automation.TogglePattern]::Pattern)
        if($pinAiToggle.Current.ToggleState.ToString() -ne 'Off'){$pinAiToggle.Toggle()}
        Invoke-PinElement (Find-Name $pinEditDialog 'Save' ([System.Windows.Automation.ControlType]::Button))
    }
    'SelectTopic' {
        Focus-Pinterest|Out-Null
        $pinTopicList=$pinRoot.FindAll([System.Windows.Automation.TreeScope]::Descendants,(New-Object System.Windows.Automation.PropertyCondition([System.Windows.Automation.AutomationElement]::ControlTypeProperty,[System.Windows.Automation.ControlType]::List)))|Where-Object{$_.Current.Name -match '^Tagged topics'}|Select-Object -First 1
        if(-not $pinTopicList){throw 'The topic suggestions are not open.'}
        $pinTopic=Find-Name $pinTopicList $Name ([System.Windows.Automation.ControlType]::ListItem)
        $pinSelectPattern=$null
        if($pinTopic -and $pinTopic.TryGetCurrentPattern([System.Windows.Automation.SelectionItemPattern]::Pattern,[ref]$pinSelectPattern)){$pinSelectPattern.Select()}else{Invoke-PinElement $pinTopic}
    }
    'Keys' {
        if($Text -notin @('^{HOME}','^{END}','{TAB}','{ESC}')){throw 'Only page navigation keys are allowed.'}
        Focus-Pinterest|Out-Null
        [System.Windows.Forms.SendKeys]::SendWait($Text)
    }
    'FillPost' {
        $pinPost=Get-Post
        Set-PinField 'Title' $pinPost.title
        Set-PinField 'Link' $pinPost.destination
        Set-PinField 'Describe your Pin' $pinPost.description
    }
    'FillAlt' {
        $pinPost=Get-Post
        Set-PinField 'Alt Text' $pinPost.alt_text
    }
    'Finalize' {
        $pinPost=Get-Post
        Focus-Pinterest|Out-Null
        [System.Windows.Forms.SendKeys]::SendWait('^{END}')
        foreach($pinSetting in @(@('Publish at a later date','Off'),@('Mark as AI-Modified Content that was made completely or partly with AI','Off'),@('This Pin includes an AI-generated person','Off'))){
            $pinCheckbox=Find-Name $pinRoot $pinSetting[0] ([System.Windows.Automation.ControlType]::CheckBox)
            if(-not $pinCheckbox){throw ('The '+$pinSetting[0]+' setting is unavailable.')}
            $pinToggle=$pinCheckbox.GetCurrentPattern([System.Windows.Automation.TogglePattern]::Pattern)
            if($pinToggle.Current.ToggleState.ToString() -ne $pinSetting[1]){$pinToggle.Toggle()}
        }
        if(-not(Find-Name $pinRoot 'Alt Text' ([System.Windows.Automation.ControlType]::Edit))){Invoke-PinElement (Find-Name $pinRoot 'More options Show more options arrow icon' ([System.Windows.Automation.ControlType]::Button))}
        Set-PinField 'Alt Text' $pinPost.alt_text
        Assert-PinDraft
    }
    'Verify' { Assert-PinDraft }
    'Publish' {
        Assert-PinDraft
        Invoke-PinElement (Find-Name $pinRoot 'Publish' ([System.Windows.Automation.ControlType]::Button))
        Start-Sleep -Milliseconds 2500
        $pinConfirmation=Find-Name $pinRoot 'Your Pin has been published!' ([System.Windows.Automation.ControlType]::Text)
        $pinComplete=Find-Name $pinRoot 'Publish Complete' ([System.Windows.Automation.ControlType]::Text)
        if(-not $pinConfirmation -and -not $pinComplete){throw 'Publication result is not confirmed. Do not retry publishing; inspect the profile first.'}
        $pinCreatedLink=Find-Name $pinRoot 'Navigate to created Pin' ([System.Windows.Automation.ControlType]::Hyperlink)
        if($pinCreatedLink){Invoke-PinElement $pinCreatedLink;Start-Sleep -Milliseconds 2000}
    }
    'VerifyPublished' {
        $pinPost=Get-Post
        Focus-Pinterest|Out-Null
        if((Get-PinUrl) -notmatch 'pinterest\.com/pin/[0-9]+/?$'){throw 'A published pin page is not open.'}
        Invoke-PinElement (Find-Name $pinRoot 'Reload' ([System.Windows.Automation.ControlType]::Button))
        Start-Sleep -Milliseconds 2500
        $pinPanel=Wait-PinElement $pinRoot 'Closeup content container'
        $pinPublicAiLabel=Find-Name $pinPanel 'AI modified' ([System.Windows.Automation.ControlType]::Text)
        $pinEditDialog=Open-PinEditor
        if((Get-PinField $pinEditDialog 'Title') -ne $pinPost.title){throw 'Published title differs from the prepared title.'}
        if((Get-PinField $pinEditDialog 'Write a description for your Pin') -ne $pinPost.description){throw 'Published description differs from the prepared description.'}
        if((Get-PinField $pinEditDialog 'Link') -ne $pinPost.destination){throw 'Published destination differs from the prepared link.'}
        $pinAiCheckbox=Find-Name $pinEditDialog 'Mark as AI-Modified Content that was made completely or partly with AI' ([System.Windows.Automation.ControlType]::CheckBox)
        $pinAiState=$pinAiCheckbox.GetCurrentPattern([System.Windows.Automation.TogglePattern]::Pattern).Current.ToggleState.ToString()
        if($pinAiState -ne 'Off'){throw 'The manual AI disclosure is still enabled.'}
        $pinBatchFile=$BatchFile
        $pinBatch=Get-Content -LiteralPath $pinBatchFile -Raw -Encoding UTF8|ConvertFrom-Json
        $pinRecord=$pinBatch.posts|Where-Object{$_.id -eq $PinId}
        $pinRecord.verified=$true
        $pinRecord.tag_update_status='verified'
        $pinRecord.manual_ai_disclosure=$false
        $pinRecord|Add-Member -NotePropertyName public_ai_label_present -NotePropertyValue ($null -ne $pinPublicAiLabel) -Force
        $pinRecord|Add-Member -NotePropertyName verification_date -NotePropertyValue '2026-10-20' -Force
        [IO.File]::WriteAllText($pinBatchFile,($pinBatch|ConvertTo-Json -Depth 10),[System.Text.UTF8Encoding]::new($false))
        [PSCustomObject]@{Pin=$PinId;VerifiedAfterReload=$true;Url=Get-PinUrl;Title=$pinPost.title;Description=$pinPost.description;Destination=$pinPost.destination;ManualAiDisclosure=$pinAiState;PublicAiLabelPresent=($null -ne $pinPublicAiLabel)}|ConvertTo-Json -Compress
    }
}
Start-Sleep -Milliseconds ([Math]::Min($WaitMilliseconds,10000))
Assert-Pinterest
if($Action -eq 'Topics'){
    $pinTopicLists=$pinRoot.FindAll([System.Windows.Automation.TreeScope]::Descendants,(New-Object System.Windows.Automation.PropertyCondition([System.Windows.Automation.AutomationElement]::ControlTypeProperty,[System.Windows.Automation.ControlType]::List)))|Where-Object{$_.Current.Name -match '^Tagged topics'}
    $pinTopicResults=foreach($pinTopicList in $pinTopicLists){$pinTopicEntries=$pinTopicList.FindAll([System.Windows.Automation.TreeScope]::Descendants,[System.Windows.Automation.Condition]::TrueCondition);foreach($pinTopicEntry in $pinTopicEntries){if($pinTopicEntry.Current.Name){[PSCustomObject]@{Name=$pinTopicEntry.Current.Name;Type=$pinTopicEntry.Current.ControlType.ProgrammaticName}}}}
    $pinTopicResults|ConvertTo-Json -Compress
}elseif($Action -eq 'Url'){
    [PSCustomObject]@{Url=Get-PinUrl}|ConvertTo-Json -Compress
}elseif($Action -in @('Inspect','Read')){
    $pinDocument=Get-PinDocument
    $pinNodes=if($Action -eq 'Read'){$pinRoot.FindAll([System.Windows.Automation.TreeScope]::Descendants,[System.Windows.Automation.Condition]::TrueCondition)}else{$pinDocument.FindAll([System.Windows.Automation.TreeScope]::Descendants,[System.Windows.Automation.Condition]::TrueCondition)}
    $pinOutput=foreach($pinNode in $pinNodes){
        $pinInfo=$pinNode.Current
        if(-not $pinInfo.Name -or ($pinInfo.IsOffscreen -and $Action -ne 'Read')){continue}
        if($Action -eq 'Read' -and $pinInfo.Name -notmatch '^(Title|Link|Alt Text|Describe your Pin|Write a description for your Pin|Publish at a later date|Mark as AI-Modified.*|This Pin includes an AI-generated person)$'){continue}
        $pinValue=$null;$pinPattern=$null
        if($pinInfo.ControlType -in @([System.Windows.Automation.ControlType]::Edit,[System.Windows.Automation.ControlType]::ComboBox) -and $pinNode.TryGetCurrentPattern([System.Windows.Automation.ValuePattern]::Pattern,[ref]$pinPattern)){$pinValue=$pinPattern.Current.Value}
        $pinState=$null;$pinPattern=$null
        if($pinInfo.ControlType -eq [System.Windows.Automation.ControlType]::CheckBox -and $pinNode.TryGetCurrentPattern([System.Windows.Automation.TogglePattern]::Pattern,[ref]$pinPattern)){$pinState=$pinPattern.Current.ToggleState.ToString()}
        [PSCustomObject]@{Name=$pinInfo.Name;Type=$pinInfo.ControlType.ProgrammaticName;Value=$pinValue;State=$pinState}
    }
    $pinOutput|Select-Object -First 90|ConvertTo-Json -Compress -Depth 3
}elseif($Action -eq 'Screenshot'){
    Focus-Pinterest|Out-Null
    $pinRect=New-Object PinBatchDesktop+RECT
    [PinBatchDesktop]::GetWindowRect($pinWindow,[ref]$pinRect)|Out-Null
    $pinBitmap=New-Object System.Drawing.Bitmap (($pinRect.Right-$pinRect.Left),($pinRect.Bottom-$pinRect.Top))
    $pinGraphics=[System.Drawing.Graphics]::FromImage($pinBitmap)
    $pinShot=Join-Path $PSScriptRoot 'pinterest-batch-current.png'
    try{$pinGraphics.CopyFromScreen($pinRect.Left,$pinRect.Top,0,0,$pinBitmap.Size);$pinBitmap.Save($pinShot,[System.Drawing.Imaging.ImageFormat]::Png)}finally{$pinGraphics.Dispose();$pinBitmap.Dispose()}
    [PSCustomObject]@{Screenshot=$pinShot}|ConvertTo-Json -Compress
}else{
    [PSCustomObject]@{Action=$Action;Control=$Name;Complete=$true;Url=Get-PinUrl}|ConvertTo-Json -Compress
}
