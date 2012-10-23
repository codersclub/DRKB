<h1>Как открыть первую ветвь TreeView?</h1>
<div class="date">01.01.2007</div>


<p>Как программным путем открыть первую ветвь и в ней выделить первый элемент?</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);

begin
  TreeView1.Items[0].Expand(False);
  TreeView1.Items[0].Selected:=true;
  TreeView1.SetFocus;
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

