const fs = require('fs').promises;
const path = require('path');

const scriptDirectory = __dirname;
const styleFilePath = path.join(scriptDirectory, '../style.css');
const readmeFilePath = path.join(scriptDirectory, '../readme.txt');
const functionsFilePath = path.join(scriptDirectory, '../functions.php');

async function incrementVersion(version, minorIncrement, majorIncrement, patchIncrement) {
  const [major, minor, patch] = version.split('.').map(Number);
  return `${major + majorIncrement}.${minor + minorIncrement}.${patch + patchIncrement}`;
}

async function updateFile(filePath, newVersion) {
  try {
    let data = await fs.readFile(filePath, 'utf8');
    const updatedData = data.replace(/(Version:\s*)(\d+\.\d+\.\d+)/, `$1${newVersion}`);
    await fs.writeFile(filePath, updatedData, 'utf8');
    console.log(`Version updated in ${filePath} to ${newVersion}`);
  } catch (err) {
    console.error(`Error updating file ${filePath}:`, err);
  }
}

async function updateReadmeStableTag(filePath, newVersion) {
  try {
    let data = await fs.readFile(filePath, 'utf8');
    const updatedData = data.replace(/(Stable tag:\s*)(\d+\.\d+\.\d+)/, `$1${newVersion}`);
    await fs.writeFile(filePath, updatedData, 'utf8');
    console.log(`Stable tag updated in ${filePath} to ${newVersion}`);
  } catch (err) {
    console.error(`Error updating file ${filePath}:`, err);
  }
}

async function main() {
  try {
    // Read the current version from the style.css file using a more flexible regex
    const currentStyleVersion = (await fs.readFile(styleFilePath, 'utf8')).match(/Version:\s*(\d+\.\d+\.\d+)/)[1];

    // Read the current version from the readme.txt file using a more flexible regex
    const currentReadmeVersion = (await fs.readFile(readmeFilePath, 'utf8')).match(/Stable tag:\s*(\d+\.\d+\.\d+)/)[1];

    // Read the current version from the functions.php file using a more flexible regex
    const currentFunctionsVersion = (await fs.readFile(functionsFilePath, 'utf8')).match(/define\('DOCUMENTATION_VERSION',\s*'(\d+\.\d+\.\d+)'\);/)[1];

    // Determine increment type
    const minorIncrement = process.argv.includes('--minor') ? 1 : 0;
    const majorIncrement = process.argv.includes('--major') ? 1 : 0;
    const patchIncrement = process.argv.includes('--patch') ? 1 : 0;

    // Increment versions
    const newStyleVersion = await incrementVersion(currentStyleVersion, minorIncrement, majorIncrement, patchIncrement);
    const newReadmeVersion = await incrementVersion(currentReadmeVersion, minorIncrement, majorIncrement, patchIncrement);
    const newFunctionsVersion = await incrementVersion(currentFunctionsVersion, minorIncrement, majorIncrement, patchIncrement);

    // Update style.css, readme.txt, and functions.php
    await updateFile(styleFilePath, newStyleVersion);
    await updateReadmeStableTag(readmeFilePath, newReadmeVersion);

    // Update functions.php
    const functionsFileData = await fs.readFile(functionsFilePath, 'utf8');
    const updatedFunctionsData = functionsFileData.replace(/(define\('DOCUMENTATION_VERSION',\s*)'(\d+\.\d+\.\d+)'(\);)/, `$1'${newFunctionsVersion}'$3`);
    await fs.writeFile(functionsFilePath, updatedFunctionsData, 'utf8');
    console.log(`Version updated in ${functionsFilePath} to ${newFunctionsVersion}`);
  } catch (err) {
    console.error('Error:', err);
  }
}

main();
