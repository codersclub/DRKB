<h1>Какой язык на данный момент на клавиатуре?</h1>
<div class="date">01.01.2007</div>


<p>Используй GetKeyboardLayoutName</p>
<div class="author">Автор: Mikel</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
var

 
Form1: TForm1;
LAYOUT: String;
implementation
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
var
  RA: Array[0..$FFF] of Char;
begin
GetKeyboardLayoutName(RA) ;
Layout := StrPas(RA);
if Layout = '00000419' then 
  showmessage(' CCCP ' ) 
else
  if Layout = '00000409' then 
    showmessage(' USA ' )
  else 
    showmessage(' X 3 ' ) ;
end; 
</pre>
<div class="author">Автор: Radmin</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
function WhichLanguage:string; 
var 
ID:LangID; 
Language: array [0..100] of char; 
begin 
ID:=GetSystemDefaultLangID; 
VerLanguageName(ID,Language,100); 
Result:=String(Language); 
end; 
</pre>
<p>Пример вызова этой функции:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Edit1.Text:=WhichLanguage; 
end;
</pre>
<p>Также, для определения активного языка можно воспользоваться функцией GetUserDefaultLangID.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

