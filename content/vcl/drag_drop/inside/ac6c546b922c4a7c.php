<h1>Как перетаскивать выделенный текст между компонентами TMemo?</h1>
<div class="date">01.01.2007</div>

Данный способ позволяет не погружаясь глубоко в создание компонент осуществить операцию "drag and drop" выделенного текста.</p>
<p>Создайте новый компонент (TMyMemo), наследовав его от TMemo. И объявите его следующим образом:</p>
<pre>
type
  TMyMemo = class(TMemo)
  private
    FLastSelStart : Integer;
    FLastSelLength : Integer;
    procedure WMLButtonDown(var message: TWMLButtonDown); message WM_LBUTTONDOWN;
  published
    property LastSelStart : Integer read FLastSelStart write FLastSelStart;
    property LastSelLength : Integer read FLastSelLength write FLastSelLength;
end;
</pre>
<p>Добавьте обработчик WMLButtonDown:</p>
<pre>
procedure TMyMemo.WMLButtonDown(var message: TWMLButtonDown);
var
  Ch: Integer;
begin
  if SelLength &gt; 0 then
  begin
    Ch := LoWord(Perform(EM_CHARFROMPOS, 0,
    MakeLParam(message.XPos, message.YPos)));
    LastSelStart := SelStart;
    LastSelLength := SelLength;
    if (Ch &gt;= SelStart) and (Ch &lt;= SelStart+SelLength-1) then
      BeginDrag(True)
    else
      inherited;
  end
  else
    inherited;
end;
</pre>
<p>Теперь установите этот компонент в package, создайте новый проект в Delphi и поместите на форму два TMyMemo. Для обоих компонент необходимо создать обработчики событий OnDragOver, которые должны выглядеть следующим образом:</p>
<pre>
procedure TForm1.MyMemo1DragOver(Sender, Source: TObject; X, Y: Integer;
State: TDragState; var Accept: Boolean);
begin
  Accept := Source is TMyMemo;
end;
</pre>
<p>Так же для них необходимо сделать обработчики событий OnDragDrop:</p>
<pre>
procedure TForm1.MyMemo1DragDrop(Sender, Source: TObject;
X, Y: Integer);
var
  Dst, Src : TMyMemo;
  Ch : Integer;
  Temp : string;
begin
  Dst := Sender as TMyMemo;
  Src := Source as TMyMemo;
  Ch := LoWord(Dst.Perform(EM_CHARFROMPOS,0,MakeLParam(X,Y)));
 
  if (Src = Dst) and (Ch &gt;= Src.LastSelStart) and
  (Ch &lt;= Src.LastSelStart+Src.LastSelLength-1) then
    Exit;
 
  Dst.Text := Copy(Dst.Text,1,Ch)+Src.SelText+
  Copy(Dst.Text,Ch+1,Length(Dst.Text)-Ch);
  Temp := Src.Text;
  Delete(Temp,Src.LastSelStart+1,Src.LastSelLength);
  Src.Text := Temp;
end;
</pre>
<p>Запустите приложение, поместите в поля memo какой-нибудь текст, и посмотрите что произойдёт, если перетащить текст между полями.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
