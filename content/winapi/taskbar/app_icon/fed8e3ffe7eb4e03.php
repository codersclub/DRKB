<h1>Как отобразить не главные окна своей программы в панели задач?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TMyForm.CreateParams(var Params :TCreateParams); {override;}
begin
  inherited CreateParams(Params); {CreateWindowEx}
  Params.ExStyle := Params.ExStyle or WS_Ex_AppWindow;
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
type
   TForm = class(TForm)
     {...}
   protected
     procedure CreateParams(var Params: TCreateParams); override;
   end;
 
 implementation
 
 {...}
 
 procedure TForm2.CreateParams(var Params: TCreateParams);
 begin
   inherited CreateParams(Params);
   Params.ExStyle   := Params.ExStyle or WS_EX_APPWINDOW;
   Params.WndParent := GetDesktopWindow;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<p>У многооконного приложения, как Delphi, обычно только одна кнопка на TaskBar. Если же вам понадобилось, чтобы у каждого окна была своя кнопка, воспользуйтесь функцией SetWindowLong, добавив флаг WS_EX_APPWINDOW.</p>
<p>В модуле первого окна:</p>
<pre>
uses Unit2, Unit3;
 
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  ShowWindow(Application.Handle, SW_HIDE);
  Form1.Hide;
  Form2.Show;
  Form3.Show;
end;
</pre>
<p>В модуле второго окна:</p>
<pre>
uses Unit3;
 
{$R *.DFM}
 
procedure TForm2.FormCreate(Sender: TObject);
begin
  SetWindowLong(Handle, GWL_EXSTYLE,
  GetWindowLong(Handle, GWL_EXSTYLE) or WS_EX_APPWINDOW);
end;
 
procedure TForm2.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  if Form3.Visible = false then
    Application.Terminate;
end;
</pre>
<p>В модуле третьего окна:</p>
<pre>
uses Unit2;
 
{$R *.DFM}
 
procedure TForm3.FormCreate(Sender: TObject);
begin
  SetWindowLong(Handle, GWL_EXSTYLE,
  GetWindowLong(Handle, GWL_EXSTYLE) or WS_EX_APPWINDOW);
end;
 
procedure TForm3.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  if Form2.Visible = false then
    Application.Terminate;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
type
  TForm2 = class(TForm)
  private
    { Private declarations }
    procedure CreateParams(var Params: TCreateParams); override;
  end;
...
 
procedure TForm2.CreateParams(var Params: TCreateParams);
begin
  inherited CreateParams(Params);
  with Params do
    ExStyle := ExStyle or WS_EX_APPWINDOW;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
