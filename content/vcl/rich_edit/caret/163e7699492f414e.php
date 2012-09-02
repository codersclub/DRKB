<h1>Позиционирование курсора как в предыдущей строке</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls, ComCtrls;
 
type
  TForm1 = class(TForm)
    Button1: TButton;
    Button2: TButton;
    RichEdit1: TRichEdit;
    procedure RichEdit1KeyPress(Sender: TObject; var Key: Char);
  private
    { Private declarations }
  public
    { Public declarations }
end;
 
var
  Form1: TForm1;
 
implementation
{$R *.DFM}
 
uses
  richedit;
 
procedure TForm1.RichEdit1KeyPress(Sender: TObject; var Key: Char);
var
  line, col, indent: integer;
  S: string;
begin
  if key = #13 then
  begin
    key := #0;
    with sender as TRichEdit do
    begin
      {figure out line and column position of caret}
      line := PerForm( EM_EXLINEFROMCHAR, 0, SelStart );
      Col := SelStart - Perform( EM_LINEINDEX, line, 0 );
      {get part of current line in front of caret}
      S:= Copy( lines[ line ], 1, col );
      {count blanks and tabs in this string}
      indent := 0;
      while (indent &lt; length( S )) and (S[indent + 1] in [' ', #9]) do
        Inc( indent );
      {insert a linebreak followed by the substring of blanks and tabs}
      SelText := #13#10 + Copy(S, 1, indent);
    end;
  end;
end;
 
end.
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
