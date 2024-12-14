  </div>

</div>

<script type="text/javascript" src="<?= APP ?>/js/jQuery.js"></script>

<script>
function tree_open_all() {
    $('.tree ul').toggleClass('all_off');
}

$(document).ready(function () {
    
  var url = window.parent.location.pathname;
  var selector = 'a[href="'+url+'"]';

  $(selector).addClass('current').focus();

  var i = 6; // Max depth level

  while(url !== '/' && i) {

    var elem = document.getElementById(url);

    if(elem) {
      elem.checked = true;
    }

    url = url.replace(/\/$/, '').replace(/\/[^\/]*$/, '/');

    i--;
  }

});
</script>


<script src="<?= APP ?>/js/tree.js"></script>

</body>
</html>
