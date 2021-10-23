const fs = require('fs');
const readline = require('readline');
const { exec } = require('child_process');

async function processLineByLine() {
  const fileStream = fs.createReadStream('.env');

  const rl = readline.createInterface({
    input: fileStream,
    crlfDelay: Infinity,
  });

  for await (const line of rl) {
    if (line !== '') {
      exec('heroku config:set ' + line, (error, stdout, stderr) => {
        if (error) {
          console.log(`error: ${error.message}`);
          return;
        }
        if (stderr) {
          console.log(`stderr: ${stderr}`);
          return;
        }

        console.log(`stdout: ${stdout}`);
      });
    }
  }
}

processLineByLine();
