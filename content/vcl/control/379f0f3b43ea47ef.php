<h1>Как использовать клавишу-акселератор в TTabSheet?</h1>
<div class="date">01.01.2007</div>



<p>Как использовать клавишу-акселератор в TTabsheets? Я добавляю клавишу-акселератор в заголовок каждого Tabsheet моего PageControl, но при попытке переключать страницы этой клавишей программа пикает и ничего не происходит. </p>

<p>Можно перехватить сообщение CM_DIALOGCHAR.</p>
<pre>
type
  TForm1 = class(TForm)
    PageControl1: TPageControl;
    TabSheet1: TTabSheet;
    TabSheet2: TTabSheet;
    TabSheet3: TTabSheet;
  private
  {Private declarations}
    procedure CMDialogChar(var Msg: TCMDialogChar);
      message CM_DIALOGCHAR;
  public
  {Public declarations}
  end;
 
var
  Form1: TForm1;
 
implementation
{$R *.DFM}
 
procedure TForm1.CMDialogChar(var Msg: TCMDialogChar);
var
  i: integer;
begin
  with PageControl1 do
    begin
      if Enabled then
        for i := 0 to PageControl1.PageCount - 1 do
          if ((IsAccel(Msg.CharCode, Pages[i].Caption)) and
            (Pages[i].TabVisible)) then
            begin
              Msg.Result := 1;
              ActivePage := Pages[i];
              exit;
            end;
    end;
  inherited;
end;
</pre>
<p>Взято из </p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>


