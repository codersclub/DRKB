<h1>Как перемещать строки и колонки в TStringGrid?</h1>
<div class="date">01.01.2007</div>


<p>Пользователь может перемещать строки и колонки StringGrid при помощи мышки. Можно ли это сделать программно? В описании TCustomGrid можно увидеть методы MoveColumn и MoveRow, однако они скрыты в TStringGrid. Но нам ничего не мешает просабклассить TStringGrid и объявить эти методы как public:</p>
<pre>
type
  TStringGridX = class(TStringGrid)
  public
    procedure MoveColumn(FromIndex, ToIndex: Longint);
    procedure MoveRow(FromIndex, ToIndex: Longint);
  end;
</pre>

<p>Чтобы воспользоваться этими методами, достаточно вызвать соответствующий метод предка:</p>
<pre>
procedure TStringGridX.MoveColumn(FromIndex, ToIndex: Integer);
begin
  inherited;
end;
 
procedure TStringGridX.MoveRow(FromIndex, ToIndex: Integer);
begin
  inherited;
end;
</pre>

<p>Этот компонент не нужно регистрировать в палитре компонентов. Просто используйте потомка TStringGrid или любого TCustomGrid, и вызывайте его методы:</p>
<pre>
  procedure TForm1.Button1Click(Sender: TObject); 
  begin 
    TStringGridX(StringGrid1).MoveColumn(1, 3); 
  end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />Примечание от Vit: код можно написать значительно компактнее:</p>

<pre>
 type TFake = class(TStringGrid);
...
 
  procedure TForm1.Button1Click(Sender: TObject); 

  begin 
    TFake(StringGrid1).MoveColumn(1, 3); 
  end;
</pre>


<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Перестановка строки в StringGrid в другую позицию
 
Передвигает строку StringGrid из позиции FromRow в позицию ToRow, сдвигая остальные
 
Зависимости: Grids
Автор:       Борис Новгородов (MBo), mbo@mail.ru, Новосибирск
Copyright:   MBo
Дата:        28 апреля 2002 г.
***************************************************** }
 
procedure SGMoveRow(SG: TStringGrid; FromRow, ToRow: Integer);
var
  TempList: TStringList;
  i: Integer;
begin
  with SG do
    if (FromRow in [0..RowCount - 1]) and (ToRow in [0..RowCount - 1]) then
    begin
      TempList := TStringList.Create;
      TempList.Assign(Rows[FromRow]);
      if FromRow &gt; ToRow then
        for i := FromRow downto ToRow + 1 do
          Rows[i].Assign(Rows[i - 1])
      else
        for i := FromRow to ToRow - 1 do
          Rows[i].Assign(Rows[i + 1]);
      Rows[ToRow].Assign(TempList);
      TempList.Free;
    end;
end;
 
</pre>

