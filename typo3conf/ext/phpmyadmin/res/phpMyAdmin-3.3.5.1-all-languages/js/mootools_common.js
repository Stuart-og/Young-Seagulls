/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 *  Used for replication support
 *
 * @version $Id: mootools_common.js 37055 2010-08-20 13:35:20Z mehrwert $
 */

function divShowHideFunc(ahref, id) {
      $(ahref).addEvent('click', function() {
      if ($(id).getStyle('display')=="none")
	$(id).tween('display', 'block');
      else
	$(id).tween('display', 'none');
    });
}
