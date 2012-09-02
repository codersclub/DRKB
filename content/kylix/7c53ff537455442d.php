<h1>Как сделать Ping?</h1>
<div class="date">01.01.2007</div>


<p>В коде используется функция ExecCmdine из статьи: <a href="z1000.htm">Как запустить консольное приложение и перехватить вывод?</a></p>
<pre>
function Ping(host:string):boolean;
  var  params, CommandLine:string;
       t:TStringList;
       i:integer;
begin
  Params := Format('-s%d ', [32]);
  Params := Params+Format('-c%d ', [1]);
  CommandLine := Format('ping %s%s', [Params, host]);
  t:=TStringList.Create;
  ExecCmdine(CommandLine, t);
  Result:=pos('1 received, 0% packet loss', t.text)&gt;0;
  t.free;
end; 
</pre>
<p class="note">Примечание</p>
<p>Под отладчиком Kylix код может не работать. Надо запускать приложение не под Kylix для того чтобы удостовериться что код работает.</p>
<p>Более подробную информацию можно получить запустив в консоле:</p>
<p>man ping </p>
<p class="author">Автор: Vit</p>

