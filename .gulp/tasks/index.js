import { task, parallel, series } from "gulp";

import { bsLocal } from "./browserSync";
import { watchFiles } from "./watch";
import { cleanDist, cleanDSStore, copyPlugin, deleteEmptyDir, updateComposer } from "./release";
import { getPluginSize, replacePluginTexts, zipPlugin } from "./release";
import { buildPluginPotFile } from "./language";
import { readmeToMarkdown } from "./general";

task("build:potFile", buildPluginPotFile);
task("build:plugin", series(cleanDist, cleanDSStore, copyPlugin, deleteEmptyDir, replacePluginTexts, updateComposer, readmeToMarkdown));
task("zip:plugin", series(zipPlugin, getPluginSize));

task("default", parallel(watchFiles, bsLocal));
