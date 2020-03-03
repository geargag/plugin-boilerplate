const paths = {
	plugin: {
		sass: {
			watch: ["src/assets/scss/**/*.scss"],
			generate: "src/assets/scss/*.scss",
		},
		files: ["src/assets/css/*.css", "src/assets/js/*.js", "src/**/*.php"],
		build: [
			"src/**",
			"!src/**/.*",
			"!src/**/phpcs.xml",
			"!src/**/package*.json",
			"!src/**/example-functions.php",
			"!src/**/*.scss",
			"!src/assets/js/src/**",
			"!src/**/*.md",
			"!src/**/*.yml",
			"!src/**/doc/**",
			"!src/**/Dockerfile",
			"!src/**/make.sh",
			"!src/**/phpunit*",
			"!src/**/README.md",
			"!src/**/CHANGELOG.md",
			"!src/**/CONTRIBUTING.md",
			"!src/**/LICENSE.md",
			"!src/**/LICENSE",
			"!src/**/phpcs*",
		],
	},
};

export default paths;
