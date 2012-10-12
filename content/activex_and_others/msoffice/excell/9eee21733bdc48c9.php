<h1>Как определить установлен ли Excel?</h1>
<div class="date">01.01.2007</div>



<p>Функция возвращает True если найден OLE-объект</p>

<p>Пример использования </p>
<pre>
  if not IsOLEObjectInstalled('Excel.Application') then
    ShowMessage('Класс не зарегистрирован')
  else
    ShowMessage('Класс найден');
 
 
function IsOLEObjectInstalled(Name: String): boolean;
var
  ClassID: TCLSID;
  Rez : HRESULT;
begin
  // Ищем CLSID OLE-объекта
  Rez := CLSIDFromProgID(PWideChar(WideString(Name)), ClassID);
 
  if Rez = S_OK then  // Объект найден
    Result := true
  else
    Result := false;
end;
</pre>

<p>Если нужна более подробная информация об объекте, можно почитать хелп по функции API CLSIDFromProgID. </p>

<p class="author">Автор: Кулюкин Олег</p>
<p>Взято с сайта <a href="https://www.delphikingdom.ru/" target="_blank">https://www.delphikingdom.ru/</a></p>
