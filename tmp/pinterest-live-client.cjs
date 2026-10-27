const fs = require('fs');
const path = require('path');
const args = process.argv.slice(2);
const command = args[0]?.startsWith('{') ? JSON.parse(args[0]) : { action: args[0] };
if (!args[0]?.startsWith('{')) for (const arg of args.slice(1)) {
  const at = arg.indexOf('=');
  if (at < 0) command.id = arg;
  else { const value = arg.slice(at + 1); command[arg.slice(0, at)] = value === 'false' ? false : value === 'true' ? true : value; }
}
command.request_id = Date.now() + '-' + Math.random().toString(36).slice(2);
const commandFile = path.join(__dirname, 'pinterest-live-command.json');
const responseFile = path.join(__dirname, 'pinterest-live-response.json');
fs.writeFileSync(commandFile + '.new', JSON.stringify(command), 'utf8');
fs.renameSync(commandFile + '.new', commandFile);
const delay = ms => new Promise(resolve => setTimeout(resolve, ms));
(async () => {
  const deadline = Date.now() + 55000;
  while (Date.now() < deadline) {
    if (fs.existsSync(responseFile)) {
      const result = JSON.parse(fs.readFileSync(responseFile, 'utf8'));
      if (result.request_id === command.request_id) { console.log(JSON.stringify(result)); if (result.error) process.exitCode=1; return; }
    }
    await delay(100);
  }
  console.log(JSON.stringify({ error: 'Driver response timed out. Inspect current state before retrying any publication.' })); process.exitCode=1;
})();
