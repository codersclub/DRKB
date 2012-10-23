<h1>Форма, изменяющая размеры без заголовка</h1>
<div class="date">01.01.2007</div>


<p>Форма изменяющая размеры без заголовка.</p>
<p>Нужно выставить свойство формы BorderStyle := bsNone;</p>
<pre>
type
  TForm1 = class(TForm)
 
  ...
 
  protected
    procedure CreateParams(var Params: TCreateParams); override;
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.CreateParams(var Params: TCreateParams);
begin
  inherited;
  Params.Style := (Params.Style or WS_THICKFRAME);
end;
</pre>

<div class="author">Автор: feriman</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
