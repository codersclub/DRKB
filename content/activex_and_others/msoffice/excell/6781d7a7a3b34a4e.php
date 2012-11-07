<h1>Как определить запущен ли Excel?</h1>
<div class="date">01.01.2007</div>


<p>Данный пример ищет активный экземпляр Excel и делает его видимым</p>

<pre class="delphi">
var
    ExcelApp : Variant;
begin
  try
    // Ищем запущеный экземплят Excel, если он не найден, вызывается исключение
    ExcelApp := GetActiveOleObject('Excel.Application');
 
    // Делаем его видимым
    ExcelApp.Visible := true;
  except
  end;
</pre>

<div class="author">Автор: Кулюкин Олег</div>
<p>Взято с сайта <a href="https://www.delphikingdom.ru/" target="_blank">https://www.delphikingdom.ru/</a></p>
