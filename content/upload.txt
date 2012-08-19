<?php
//	header('Content-type: text/html; charset=UTF-8');

	include_once (_D_."/ninja.php");

	echo js_insert_ninja();
	echo css_insert_ninja("224px");
?>

<script type="text/javascript">
var obj = null;
function checkHover(){
  if (obj) { $('#nav').fadeOut('fast'); }
}
$(document).ready(function(){

  $('#nav').hover(
    function(){
      if (!obj){
        $('#nav').fadeOut('fast');
        obj = null;
      }
    },
    function() {
      obj = $('#nav');
      setTimeout("checkHover()", 400);
    }
  );
  $('#code').click(function(e){
    $("#nav").css("left", e.pageX + 'px');
    $("#nav").css("top", e.pageY + 'px');
    $('#nav').fadeIn('fast');
    obj = $('#nav');
  });
  $("#nav > li > a").click(function(){ $('#nav').fadeOut('fast'); });
  $("#nav > li").mouseover(function(){
    $(this).css("background", "#ffe7bd"); $(this).css("border", "1px solid #707070");
  }).mouseout(function(){
    $(this).css("background", "#eee"); $(this).css("border", "1px solid #eee");
  });
});
</script>

  <ul id="nav">
    <li><a href="javascript: voidPutATag('[code=cpp]','[/code]','content')">C++</a></li>
    <li><a href="javascript: voidPutATag('[code=csharp]','[/code]','content')">C&#35;</a></li>
    <li><a href="javascript: voidPutATag('[code=css]','[/code]','content')">CSS</a></li>
    <li><a href="javascript: voidPutATag('[code=delphi]','[/code]','content')">Delphi</a></li>
    <li><a href="javascript: voidPutATag('[code=java]','[/code]','content')">Java</a></li>
    <li><a href="javascript: voidPutATag('[code=jscript]','[/code]','content')">JavaScript</a></li>
    <li><a href="javascript: voidPutATag('[code=php]','[/code]','content')">PHP</a></li>
    <li><a href="javascript: voidPutATag('[code=python]','[/code]','content')">Python</li>
    <li><a href="javascript: voidPutATag('[code=ruby]','[/code]','content')">Ruby</li>
    <li><a href="javascript: voidPutATag('[code=sql]','[/code]','content')">SQL</a></li>
    <li><a href="javascript: voidPutATag('[code=vb]','[/code]','content')">Visual Basic</a></li>
    <li><a href="javascript: voidPutATag('[code=xml]','[/code]','content')">XML</a></li>
  </ul>

  <h1>Добавить материал</h1>

      <p>Станьте одним из авторов <strong>DRKB</strong> или просто помогите расширить базу знаний!</p>
      <p>Проект все время нуждается в новых интересных статьях и актуальных обновлениях. Особенно нуждаются в обновлениях такие разделы, как <b>Delphi&nbsp;Prizm</b> (Delphi&nbsp;.NET), <b>Базы&nbsp;Данных</b>, <b>Графика&nbsp;и&nbsp;Мультимедиа</b> и <b>Математика&nbsp;и&nbsp;Алгоритмы</b>.</p>
      <p>Если вы ведете разработку на <strong>Delphi</strong> под любую из платформ и можете дополнить базу своими статьями или если вы просто знаете хорошую статью в сети, то не проходите мимо. Ваши знания или дополнения и поправки к уже существующим статьям могут быть полезны многим людям. Автор проекта примет к рассмотрению все от простых обзорных статей и примеров использования различных компонентов до объемных in-depth FAQ и руководств по системному программированию. Особый приоритет отдается реализациям различных алгоритмов на языке Delphi. Принимаются статьи на <em>русском и английском</em> языках.</p>
      <p>Отправить интересный материал можно прямо отсюда. Для этого воспользуйтесь формой ниже:</p>

      <form name="sendform" method="post" action="" target="_blank">
        <p class="small">Заголовок статьи:<span class="star">*</span></p>
        <input type="textbox" name="title" size="88" />

        <br />

        <input type="hidden" name="date" value=<?php echo '"'.date("d.m.Y").'"' ?> />

        <div style="width: 600px; display: block;">
          <div style="width: 300px; float: left;">
            <p class="small">Автор (желательно настоящее имя):</p>
            <input type="textbox" name="author" size="38" />

            <p class="small">Сайт или электропочта:</p>
            <input type="textbox" name="author_url" size="38" />
          </div>

          <div style="width: 300px; float: left;">
            <p class="small">Источник (название):</p>
            <input type="textbox" name="source" size="38" />

            <p class="small">Полная ссылка на источник:</p>
            <input type="textbox" name="source_url" size="38" />
          </div>

          <p class="small">Содержание:<span class="star">**</span></p>


<?php echo html_insert_ninja('content'); ?>

          <textarea name="content" cols="100" rows="16"></textarea>

          <br /><br /><br />

          <button type="button" name="preview" onclick="document.sendform.action='<?= _U_ ?>/preview.php'; document.sendform.submit();">Предварительный просмотр</button>

        </div>

        <p class="small"><span class="star">*</span>Обязательно для заполнения, название должно отражать суть статьи<br />
        <span class="star">**</span>Не менее двух коротких предложений, не считая тегов<br /><br /></p>

        <button type="button" name="send" style="font-weight: bold" onclick="document.sendform.action='<?= _U_ ?>/send.php'; document.sendform.submit();">Отправить</button>
      </form>

      <br />

      <p><b>Примечания к оформлению.</b>
      <br>Статьи DRKB имеют очень простой шаблонный формат и требуют минимального оформления: заголовки разделов пометьте жирным и отбейте сверху и снизу, а все программные коды поместите в соответствующий тег. Остальное&nbsp;&mdash; на ваше усмотрение.
      <br>Перед отправкой статьи воспользуйтесь предпросмотром, чтобы убедиться, что с разметкой все в порядке.
      <br>Авторы оставляют за собой право внести в статью финальные правки (исправить ошибки, унифицировать оформление, и т.д.).</p>
