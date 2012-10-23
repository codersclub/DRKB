<h1>Как использовать параметры коммандной строки?</h1>
<div class="date">01.01.2007</div>


<p>Paramcount - показывает сколько параметров передано</p>
<p>Paramstr(0) - это имя с путем твоей программы</p>
<p>Paramstr(1) - имя первого параметра</p>
<p>Paramstr(2) - имя второго параметра и т.д.</p>
<p>Если ты запускаешь:</p>
<p>с:\myprog.exe /a -b22 c:\dev</p>
<p>то Paramcount будет равен 3</p>
<p>Paramstr(0) будет равен с:\myprog.exe</p>
<p>Paramstr(1) будет равен /a</p>
<p>Paramstr(2) будет равен -b22</p>
<p>Paramstr(3) будет равен c:\dev </p>
<p>Параметр это просто строка, набор букв, выполнить ее нельзя - ты можешь только проверить на наличие строки и если она присутствует, то выполнить какое либо действие, это действие ты должен написать сам, никаких стандартных действий нет.</p>
<p>Например у тебя возможно 3 параметра: </p>
<p>Если параметр = "/v" то выдать сообщение, если параметр "/c" то покрасить форму в синий цвет, если параметр "/f" - поменять заголовок формы:</p>
<pre>
if paramstr(1) = '/v' then
  showmessage('Parameter "/v" was found!');
if paramstr(1) = '/c' then
  color := clBlue;
if paramstr(1) = '/f' then
  caption := 'Parameter "/f" was found';
</pre>
<p>Поставь этот код на событие формы onActivate, откомпиллируй и попробуй запустить программу с одним из 3х указанных параметров и ты увидишь что произойдет. </p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Функция </p>
<pre>
function FindCmdLineSwitch(const Switch: string;
                           SwitchChars: TSysCharSet;IgnoreCase: Boolean ): Boolean; 
type TSysCharSet = set of Char;
</pre>
<p>Функция определяет, была ли передана приложению в качестве параметра командной строки строка Switch. Параметр IgnoreCase указывает должен ли учитываться регистр. Параметр SwitchChars идентифицирует допустимые символы-разделители (например, "-", "/").</p>
<p>Взято с <a href="https://atrussk.ru/delphi/" target="_blank">https://atrussk.ru/delphi/</a></p>

