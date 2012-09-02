<h1>Как проверить инсталлирован ли MS Word?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  ..., Registry;
 
function IsMicrosoftWordInstalled: Boolean;
var
  Reg: TRegistry;
  S: string;
begin
  Reg := TRegistry.Create;
  with Reg do
  begin
    RootKey := HKEY_CLASSES_ROOT;
    Result := KeyExists('Word.Application');
    Free;
  end;
end;
</pre>

<hr />
<pre>
function MSWordIsInstalled: Boolean;
begin
  Result := AppIsInstalled('Word.Application');
end;
 
function AppIsInstalled(strOLEObject: string): Boolean;
var
  ClassID: TCLSID;
begin
  Result := (CLSIDFromProgID(PWideChar(WideString(strOLEObject)), ClassID) = S_OK)
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

<hr />Как определить установлен ли на компьютере Word, запустить его и загрузить в него текст из программы? </p>

<p>Пример: </p>

<pre>
var
 MsWord: Variant;
...
try
 // Если Word уже запущен
 MsWord := GetActiveOleObject('Word.Application');
 // Взять ссылку на запущенный OLE объект
 except
  try
  // Word не запущен, запустить
  MsWord := CreateOleObject('Word.Application');
  // Создать ссылку на зарегистрированный OLE объект
  MsWord.Visible := True;
   except
    ShowMessage('Не могу запустить Microsoft Word');
    Exit;
   end;
  end;
 end;
...
MSWord.Documents.Add; // Создать новый документ
MsWord.Selection.Font.Bold := True; // Установить жирный шрифт
MsWord.Selection.Font.Size := 12; // установить 12 кегль
MsWord.Selection.TypeText('Текст');
</pre>

<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>

