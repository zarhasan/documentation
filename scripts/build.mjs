import { $, cd, fs, glob, path } from "zx";
import { format } from "date-fns";
import wpPot from "wp-pot";

const slug = 'documentation';
const name = 'Documentation';

const regex = {
  themeName: /\[THEME_NAME\]/g,
  textDomain: /\[TEXT_DOMAIN\]/g,
  themeVersion: /\[THEME_VERSION\]/g,
  themeNamespace: /THEME_NAMESPACE/g,
};

const source = {
  theme:
    "/var/www/html/redoxbird-documentation-theme/wp-app/wp-content/themes/documentation/",
};

const destination = `/home/khizar/Downloads/wp-themes/${slug}`;

const today = format(new Date(), "dd-MM-yyyy");

const themeGlob = [
  "!vendor",
  "!assets",
  "**/*.php",
  "**/*.css",
  "**/*.js",
  "**/*.json",
  "**/*.txt",
];

for (const key in source) {
  const directory = source[key];

  if (!fs.existsSync(directory)) {
    throw new Error(`${directory} does not exits`);
  }
}

if (!fs.existsSync(destination)) {
  fs.mkdirSync(destination);
  console.log(`Created directory ${destination}`);
}

if (!fs.existsSync(`${destination}/${today}`)) {
  fs.mkdirSync(`${destination}/${today}`);
  console.log(`Created directory ${destination}/${today}`);
}

if (!fs.existsSync(`${destination}/${today}/${slug}`)) {
  fs.mkdirSync(`${destination}/${today}/${slug}`);
  console.log(`Created directory ${destination}/${today}/${slug}`);
}

cd(source.theme);

await $`rsync -av --delete --exclude-from=${source.theme}.rsyncignore ${source.theme} ${destination}/${today}/selleradise`;

cd(`${destination}/${today}/${slug}`);

const full_theme_paths = await glob(themeGlob);

for (const index in full_theme_paths) {
  const file = full_theme_paths[index];

  await replaceText({
    file: file,
    textDomain: slug,
    themeName: name,
    themeNamespace: name,
  });
}

wpPot({
  destFile: `languages/${slug}.pot`,
  domain: slug,
  package: name,
  src: "**/*.php",
});


cd(`${destination}/${today}`);

await $`zip -FSrqq ${slug}.zip ${slug}`;


async function replaceText({
  file,
  textDomain,
  themeName,
  themeNamespace,
}) {
  const original_content = await fs.promises.readFile(file, "utf8");
  let content = original_content;

  if (regex.textDomain.test(content)) {
    content = content.replace(regex.textDomain, textDomain);
  }

  if (regex.themeName.test(content)) {
    content = content.replace(regex.themeName, themeName);
  }

  if (regex.themeNamespace.test(content)) {
    content = content.replace(regex.themeNamespace, themeNamespace);
  }

  await fs.promises.writeFile(file, content, "utf8");
}