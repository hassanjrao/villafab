# Pinterest website claim — 27 October 2026

## Status and exact verification value

Pinterest supplied this public website-verification tag in the logged-in Villa Fabulosa account's Claim dialog on 27 October 2026 (Asia/Karachi):

```html
<meta name="p:domain_verify" content="923d3954a887ef396dc38b526682156f" />
```

This is a public verification identifier, not a password. The corresponding Laravel setting is:

```dotenv
PINTEREST_DOMAIN_VERIFY=923d3954a887ef396dc38b526682156f
```

The repository already tracks the required application support:

- `config/services.php` reads `PINTEREST_DOMAIN_VERIFY` into `services.pinterest.domain_verify`.
- `resources/views/layouts/partials/head.blade.php` emits one escaped `p:domain_verify` meta tag when the configured value is nonempty.
- `.env.example` documents the setting. The actual `.env` must remain untracked.

The verification setting has been installed in production using the authorized server access supplied by the user. Both Laravel cache refreshes succeeded, and independent public-HTML checks confirm exactly one matching tag on both hostnames. Pinterest then explicitly confirmed that `villafabulosa.com` was claimed on 27 October 2026. No passwords, private keys, or sessions are recorded here.

Deployment receipt on 27 October 2026:

- Confirmed production checkout revision: `807aaef`; PHP `8.2.35`.
- The existing config and shared-head support were present; no production application-code changes were needed.
- Only `PINTEREST_DOMAIN_VERIFY` was added to the production environment using an atomic write. Existing unrelated diagnostic files were left untouched.
- A private environment backup was created outside the checkout under `/home/dh_2f8vmn/.private-backups/pinterest`, with a private directory (`0700`) and backup (`0600`). It must never be committed or exposed publicly.
- `php artisan config:cache` and `php artisan view:cache` both completed successfully.
- Canonical and `www` public requests both returned HTTP 200; each final HTML head contained exactly one `p:domain_verify` tag with the expected token.
- Pinterest's account-side ownership confirmation succeeded: the dialog's accessible label was **Website claimed**, with **Connected**, **You're all set!**, and `villafabulosa.com`. The underlying Websites list showed the domain with **Unclaim**.
- After the success dialog was closed, a fresh visit to Claimed accounts settings again showed `villafabulosa.com` with **Unclaim**. The dedicated readback returned `claimed: true` and `reloaded_readback: true`, confirming that the claim persisted after reload.

## Established production route and read-only preflight

Prior production deployment evidence is in `docs/accessibility.md`. The established host and checkout are:

```text
SSH: dh_2f8vmn@iad1-shared-b8-39.dreamhost.com
Checkout: /home/dh_2f8vmn/villafabulosa-new
Web root: /home/dh_2f8vmn/villafabulosa-new/public
```

Using a working authorized SSH authentication method, connect to that exact host and run this read-only preflight. Do not print `.env`, cached configuration, private keys, or credentials.

```sh
cd /home/dh_2f8vmn/villafabulosa-new
pwd
git rev-parse HEAD
git status --short
php -v | head -n 1
php -l config/services.php
grep -n -E 'pinterest|PINTEREST_DOMAIN_VERIFY|domain_verify' config/services.php
grep -n -E 'pinterestDomainVerify|p:domain_verify' resources/views/layouts/partials/head.blade.php
```

The expected config and Blade support must be present before setting the environment value. If missing, deploy the reviewed, tracked support through the established Git workflow, preserving any server changes. Do not blindly reset the checkout, overwrite local server changes, or pull an unreviewed revision. No new application implementation is needed in the current repository.

## Back up and update only the verification environment setting

The following instructions are retained for an authorized future repeat or recovery. The setting is already deployed; no repeat is needed now. Run in the confirmed production checkout after the preflight. This script changes only `PINTEREST_DOMAIN_VERIFY`, preserves all other environment bytes and file permissions, creates a private backup outside the checkout, and refuses an ambiguous duplicate setting. It does not display environment contents.

```sh
python3 - <<'PY'
from pathlib import Path
from datetime import datetime, timezone
import os
import re
import shutil
import stat
import tempfile

root = Path('/home/dh_2f8vmn/villafabulosa-new').resolve()
if Path.cwd().resolve() != root:
    raise SystemExit('Stop: production checkout path mismatch.')
env_path = root / '.env'
if not env_path.is_file() or env_path.is_symlink():
    raise SystemExit('Stop: expected regular production .env file is unavailable.')
original = env_path.read_bytes()
pattern = re.compile(rb'(?m)^PINTEREST_DOMAIN_VERIFY=[^\r\n]*')
matches = list(pattern.finditer(original))
if len(matches) > 1:
    raise SystemExit('Stop: duplicate verification settings require review.')
new_line = b'PINTEREST_DOMAIN_VERIFY=923d3954a887ef396dc38b526682156f'
newline = b'\r\n' if b'\r\n' in original else b'\n'
updated = (pattern.sub(new_line, original, count=1) if matches else
           original + (b'' if original.endswith(b'\n') else newline) + new_line + newline)
if updated == original:
    print('Verification environment setting already matches; no file change.')
else:
    stamp = datetime.now(timezone.utc).strftime('%Y%m%dT%H%M%SZ')
    private_root = root.parent / '.private-backups'
    private_root.mkdir(mode=0o700, exist_ok=True)
    backup_dir = private_root / 'pinterest'
    backup_dir.mkdir(mode=0o700, exist_ok=True)
    backup_dir.chmod(0o700)
    backup = backup_dir / ('.env.before-pinterest-' + stamp)
    if backup.exists():
        raise SystemExit('Stop: backup name already exists.')
    shutil.copy2(env_path, backup)
    backup.chmod(0o600)
    mode = stat.S_IMODE(env_path.stat().st_mode)
    descriptor, temporary = tempfile.mkstemp(prefix='.env.pinterest-', dir=root)
    try:
        with os.fdopen(descriptor, 'wb') as stream:
            stream.write(updated)
        os.chmod(temporary, mode)
        os.replace(temporary, env_path)
    finally:
        if os.path.exists(temporary):
            os.unlink(temporary)
    print('Updated only the Pinterest environment setting; private backup created.')
PY

php artisan config:cache
php artisan view:cache
```

If a cache command fails, investigate that error before requesting verification. Do not publish a partial success claim. The backup contains production secrets: never commit it, place it under `public`, or attach it to a report.

## Verify the live HTML, then claim in Pinterest

Run the following public, read-only check from a machine that can reach the website. It checks the actual HTML `<head>` for exactly one tag and the exact token on both hostnames, follows ordinary redirects, and displays no page or session contents.

```sh
python3 - <<'PY'
from html.parser import HTMLParser
from urllib.request import Request, urlopen

expected = '923d3954a887ef396dc38b526682156f'

class HeadTags(HTMLParser):
    def __init__(self):
        super().__init__()
        self.in_head = False
        self.values = []
    def handle_starttag(self, tag, attrs):
        if tag.lower() == 'head':
            self.in_head = True
        if self.in_head and tag.lower() == 'meta':
            values = dict(attrs)
            if values.get('name', '').lower() == 'p:domain_verify':
                self.values.append(values.get('content', ''))
    def handle_endtag(self, tag):
        if tag.lower() == 'head':
            self.in_head = False

for url in ('https://villafabulosa.com/', 'https://www.villafabulosa.com/'):
    request = Request(url, headers={'User-Agent': 'VillaFabulosa-domain-claim-check/1.0'})
    with urlopen(request, timeout=30) as response:
        parser = HeadTags()
        parser.feed(response.read().decode('utf-8', errors='replace'))
        if response.status != 200 or parser.values != [expected]:
            raise SystemExit('FAIL: public verification tag mismatch at ' + url)
        print('PASS:', url, '->', response.geturl(), 'HTTP 200, one matching head tag')
PY
```

Once both public checks pass:

1. In Villa Fabulosa's Pinterest Business account, open **Settings > Claimed accounts > Websites > Claim**.
2. Continue from the HTML-tag flow and verify `villafabulosa.com`.
3. Read back the claimed-website entry or explicit success message after Pinterest processes the request.
4. Record the claimed domain, verification date, deployed revision, and public-tag check in the campaign tracker and rules. Keep the tag installed for ownership verification.

Do not treat a submitted verification request, local code support, or a matching public tag alone as Pinterest's confirmation of ownership.

## Live observation during preparation

Independent post-deployment raw-HTML checks on 27 October 2026 returned HTTP 200 for both requested URLs:

| Requested URL | Final URL | `p:domain_verify` tags in `<head>` | Exact token present |
| --- | --- | --- | --- |
| `https://villafabulosa.com/` | `https://villafabulosa.com/` | 1 | Yes |
| `https://www.villafabulosa.com/` | `https://villafabulosa.com/` | 1 | Yes |

The live verification tag is present and matches Pinterest's account-specific value. These checks used `curl` with ordinary redirects and strict connection/request timeouts, followed by inspection of the raw HTML `<head>`. Before installation, the same public checks found zero verification tags; those earlier observations describe the previous state. Pinterest separately accepted the claim through its explicit **Website claimed** success dialog and the domain's **Unclaim** control, as recorded above.
