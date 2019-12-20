/* ============================== */
/* $TABLE OF CONTENTS             */
/* ============================== */

/*

	> $COMPILE LESS
	> $IMPORT LESS FILES
	> $TEXT REPLACE
	> $CSS MINIFY
	> $FILES BANNER
	> $WATCH CHANGES
	> $REGISTER TASKS

*/

module.exports = 
function ( grunt ) 
{

	// load grunt tasks from devDependencies in "package.json" file
	require('load-grunt-tasks')(grunt, { scope : 'devDependencies' });

	grunt.initConfig
	(
		{

			/* ============================== */
			/* $COMPILE LESS                  */
			/* ============================== */

			less : 
			{
				compileCore : 
				{
					src  : 'less/bootstrap.less',
					dest : 'css/bootstrap.css'
				},
			},

			/* ============================== */
			/* $IMPORT LESS FILES             */
			/* ============================== */

			less_imports : 
			{
				options : 
				{
					banner : ''
				},

				styles : 
				{
					src : 
					[
						'less/_general/variables.less',
						'less/_general/mixins/**/*.less',
						'less/reset/*.less',
						'less/base/*.less',
						'less/grid/*.less',
						'less/**/*.less',
						'!less/bootstrap.less'
					],

					dest : 'less/bootstrap.less'
				}
			},

			/* ============================== */
			/* $TEXT REPLACE                  */
			/* ============================== */

			replace : 
			{
				target : 
				{
					src  : ['less/bootstrap.less'],
					dest : 'less/bootstrap.less',
					replacements : 
					[
						{
							from : '\\',
							to   : '/'
						},
					]
				}
			},

			/* ============================== */
			/* $CSS MINIFY                    */
			/* ============================== */

			cssmin : 
			{
				minify : 
				{
					src  : 'css/bootstrap.css',
					dest : 'css/bootstrap.min.css',
				}
			},

			/* ============================== */
			/* $FILES BANNER                  */
			/* ============================== */

			usebanner : 
			{
				options : 
				{
					position : 'top',
					banner   : '/*!\n' +
									' * Flatron Bootstrap 3 Flat Theme v1.0.1\n' +
									' * Copyright to Krazicode\n' +
									' */\n',
				},

				files : 
				{
					src : 
					[ 
						'css/bootstrap.css',
						'css/bootstrap.min.css'
					]
				}
			},

			/* ============================== */
			/* $WATCH CHANGES                 */
			/* ============================== */

			watch : 
			{
				less : 
				{
					files : ['less/**/*.less', '!less/bootstrap.less'],
					tasks : ['compile']
				}
			},

		}// eof : initConfig object
	);// eof : initConfig

	/* ============================== */
	/* $REGISTER TASKS                */
	/* ============================== */

	grunt.registerTask('compile', ['less_imports', 'replace', 'less', 'cssmin', 'usebanner']);
	grunt.registerTask('default', ['compile', 'watch']);

}// eof : exports