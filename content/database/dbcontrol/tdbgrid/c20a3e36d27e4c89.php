<h1>Как убрать HScroll у TDBGrid?</h1>
<div class="date">01.01.2007</div>


<p>Нужные нам свойства существуют, но вынесены в секцию Protected предка DBGrid: TCustomGrid. Наиболее правильным способом было бы создание класса наследника от TDBGrid с выводом ScrollBars в секцию Public, но можно обойтись и без этого следующим способом:</p>
<pre>

 
Type TFake=class(TCustomGrid);
 
implementation
 
{$R *.dfm}
 
procedure TForm1.Button1Click(Sender: TObject);
begin
TFake(DBGrid1).ScrollBars:=ssVertical;
end;
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

