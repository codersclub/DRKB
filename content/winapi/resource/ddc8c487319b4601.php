<h1>Хранение данных в EXE-файле</h1>
<div class="date">01.01.2007</div>


<p>Вы можете включить любой тип данных как RCDATA или пользовательских тип ресурса. Это очень просто. Данный совет покажет вам общую технику создания такого ресурса.</p>
<pre>
Type
  TStrItem = String[39];  { 39 символов + байт длины -&gt; 40 байтов }
  TDataArray = Array [0..7, 0..24] of TStrItem;
 
Const
  Data: TDataArray = (
  ('..', ...., '..' ),  { 25 строк на строку }
  ...                   { 8 таких строк }
  ('..', ...., '..' )); { 25 строк на строку }
</pre>


<p>Данные размещаются в вашем сегменте данных и занимают в нем 8K. Если это слишком много для вашего приложения, поместите реальные данные в ресурс RCDATA. Следующие шаги демонстрируют данный подход. Создайте небольшую безоконную программку, объявляющую типизированную константу как показано выше, и запишите результат в файл на локальный диск:</p>
<pre>
program MakeData;
type
  TStrItem = string[39]; { 39 символов + байт длины -&gt; 40 байтов }
  TDataArray = array[0..7, 0..24] of TStrItem;
 
const
  Data: TDataArray = (
    ('..', ...., '..'), { 25 строк на строку }
    ... { 8 таких строк }
    ('..', ...., '..')); { 25 строк на строку }
 
var
  F: file of TDataArray;
begin
  Assign(F, 'data.dat');
  Rewrite(F);
  Write(F, Data);
  Close(F);
end.
</pre>


<p>Теперь подготовьте файл ресурса и назовите его DATA.RC. Он должен содержать только следующую строчку:</p>

<p> DATAARRAY RCDATA "data.dat"</p>

<p>Сохраните это, откройте сессию DOS, перейдите в каталог где вы сохранили data.rc (там же, где и data.dat!) и выполните следующую команду:</p>
<p> brcc data.rc&nbsp;&nbsp; (brcc32 для Delphi 2.0)</p>
<p>Теперь вы имеете файл data.res, который можете подключить к своему Delphi-проекту. Во время выполнения приложения вы можете генерировать указатель на данные этого ресурса и иметь к ним доступ, что и требовалось.</p>
<pre>
 
{ в секции interface модуля  }
type
  TStrItem = string[39]; { 39 символов + байт длины -&gt; 40 байтов }
  TDataArray = array[0..7, 0..24] of TStrItem;
  PDataArray = ^TDataArray;
const
  pData: PDataArray = nil; { в Delphi 2.0 используем Var }
 
implementation
{$R DATA.RES}
 
procedure LoadDataResource;
var
  dHandle: THandle;
begin
  { pData := Nil; если pData - Var }
  dHandle := FindResource(hInstance, 'DATAARRAY', RT_RCDATA);
  if dHandle &lt;&gt; 0 then
  begin
    dhandle := LoadResource(hInstance, dHandle);
    if dHandle &lt;&gt; 0 then
      pData := LockResource(dHandle);
  end;
  if pData = nil then
    { неудача, получаем сообщение об ошибке с помощью
    WinProcs.MessageBox, без помощи VCL, поскольку здесь код
    выполняется как часть инициализации программы и VCL
    возможно еще не инициализирован! }
end;
 
initialization
  LoadDataResource;
end.
</pre>

<p>Теперь вы можете ссылаться на элементы массива с помощью синтаксиса pData^[i,j].</p>

<div class="author">Автор: Peter Below</div><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
