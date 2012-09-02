<h1>Как создать компонент во время выполнения приложения?</h1>
<div class="date">01.01.2007</div>


<p>При создании визуальных контролов в runtime, важным моментом является назначение родительских свойств и использование метода SetBounds, чтобы этот контрол стал видимы.</p>

<pre>
type 
  TForm1 = class(TForm) 
  protected 
    MyLabel: TLabel; 
    procedure LabelClick(Sender: TObject); 
    procedure CreateControl; 
  end; 
 
procedure TForm1.LabelClick(Sender: TObject); 
begin 
  (Sender as Label).Caption := ... 
end; 
 
procedure TForm1.CreateControl; 
var 
  ALeft, ATop, AWidth, AHeight: Integer; 
begin 
  ALeft := 10; 
  ATop := 10; 
  AWidth := 50; 
  AHeight := 13; 
  MyLabel := TLabel.Create(Self); 
  MyLabel.Parent := Self;       
  MyLabel.Name:='LabelName'; 
  MyLabel.SetBounds(ALeft, ATop, AWidth, AHeight); 
  MyLabel.OnClick := LabelClick; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
