<h1>Как показать подсказки Hints для элементов меню</h1>
<div class="date">01.01.2007</div>

В примере создается обработчик события Application.Hint - подсказки меню изображаются на status Panel: </p>
<pre>
type
  TForm1 = class(TForm)
    Panel1: TPanel;
    MainMenu1: TMainMenu;
    MenuItemFile: TMenuItem;
    MenuItemOpen: TMenuItem;
    MenuItemClose: TMenuItem;
    OpenDialog1: TOpenDialog;
    procedure FormCreate(Sender: TObject);
    procedure MenuItemCloseClick(Sender: TObject);
    procedure MenuItemOpenClick(Sender: TObject);
  private
    {Private declarations}
    procedure HintHandler(Sender: TObject);
  public
    {Public declarations}
end;
 
var
  Form1: TForm1;
 
implementation
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Panel1.Align := alBottom;
  MenuItemFile.Hint := 'File Menu';
  MenuItemOpen.Hint := 'Opens A File';
  MenuItemClose.Hint := 'Closes the Application';
  Application.OnHint := HintHandler;
end;
 
procedure TForm1.HintHandler(Sender: TObject);
begin
  Panel1.Caption := Application.Hint;
end;
 
procedure TForm1.MenuItemCloseClick(Sender: TObject);
begin
  Application.Terminate;
end;
 
procedure TForm1.MenuItemOpenClick(Sender: TObject);
begin
  if OpenDialog1.Execute then
    Form1.Caption := OpenDialog1.FileName;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

