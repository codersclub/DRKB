<h1>Как удалить строку из TStringGrid в runtime?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Song</div>
<p>Можно сделать наследника от TCustomGrid. А у последнего есть метод - DeleteRow.</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<p>Например удаление текущей строки:</p>
<pre>
Type TFakeGrid=class(TCustomGrid);

 
procedure TForm1.MyDelete(Sender: TObject);
begin
  TFakeGrid(Grid).DeleteRow(Grid.row);
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<p class="note">Примечание от bur80 (Sources.ru):</p>
<p>Предлагаю в разделе VCL -&gt; StringGrid внести корректировочку в статью "Как удалить строку в StringGrid в run-time", что данный метод(!) будет работать только в случае если форма создаётся вот так:</p>
<pre>
...
Form1.ShowModal;
...
</pre>
<p> <br>
<p>а не так:</p>
<pre>
...
var
fr1 : TForm1;
begin
fr1 := Tform1.Create(Application);
fr1.Show;
...
</pre>
 <br>

<hr />

<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Удаление строки из StringGrid
 
Удаляет из StringGrid указанную строку, сдвигая остальные.
 
Зависимости: Grids
Автор:       Борис Новгородов (MBo), mbo@mail.ru, Новосибирск
Copyright:   MBo
Дата:        27 апреля 2002 г.
***************************************************** }
 
procedure SGDeleteRow(SG: TStringGrid; RowToDelete: Integer);
var
  i: Integer;
begin
  with SG do
  begin
    if (RowToDelete &gt;= 0) and (RowToDelete &lt; RowCount) then
    begin
      for i := RowToDelete to RowCount - 2 do
        Rows[i].Assign(Rows[i + 1]);
      RowCount := RowCount - 1;
    end;
  end;
end;
 
</pre>
</p>
<hr />
<pre>
procedure GridDeleteRow(RowNumber: Integer; Grid: TstringGrid);
 var
   i: Integer;
 begin
   Grid.Row := RowNumber;
   if (Grid.Row = Grid.RowCount - 1) then
     { On the last row}
     Grid.RowCount := Grid.RowCount - 1
   else
   begin
     { Not the last row}
     for i := RowNumber to Grid.RowCount - 1 do
       Grid.Rows[i] := Grid.Rows[i + 1];
     Grid.RowCount := Grid.RowCount - 1;
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   GridDeleteRow(3, stringGrid1);
 end;
</pre>

<div class="author">Автор: Борис Новгородов (MBo), mbo@mail.ru</div>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
