<h1>Как принимать перетаскиваемые файлы из проводника?</h1>
<div class="date">01.01.2007</div>


<p>Вот пример с TListbox на форме:</p>
<pre>
type 
  TForm1 = class(TForm) 
    ListBox1: TListBox; 
    procedure FormCreate(Sender: TObject); 
  protected 
    procedure WMDROPFILES (var Msg: TMessage); message WM_DROPFILES; 
  private 
  public 
  end; 
 
var 
  Form1: TForm1; 
 
implementation 
uses shellapi; 
 
{$R *.DFM} 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  DragAcceptFiles(Form1.Handle, true); 
end; 
 
procedure TForm1.WMDROPFILES (var Msg: TMessage); 
var 
  i, 
  amount, 
  size: integer; 
  Filename: PChar; 
begin 
  inherited; 
  Amount := DragQueryFile(Msg.WParam, $FFFFFFFF, Filename, 255); 
  for i := 0 to (Amount - 1) do 
  begin 
    size := DragQueryFile(Msg.WParam, i , nil, 0) + 1; 
    Filename:= StrAlloc(size); 
    DragQueryFile(Msg.WParam,i , Filename, size); 
    listbox1.items.add(StrPas(Filename)); 
    StrDispose(Filename); 
  end; 
  DragFinish(Msg.WParam); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


