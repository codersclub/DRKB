<h1>Работа с Sender</h1>
<div class="date">01.01.2007</div>


<pre>
unit TestInputForm;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, DdhInpuB;
 
type
  TForm1 = class(TForm)
    Edit1: TEdit;
    Label1: TLabel;
    DdhInputButton1: TDdhInputButton;
    DdhInputButton2: TDdhInputButton;
    DdhInputButton3: TDdhInputButton;
    procedure DdhInputButtonClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.DdhInputButtonClick(Sender: TObject);
begin
  ShowMessage ('You have clicked the ' +
    (Sender as TButton).Name + ','#13 +
    'having the caption ' +
    (Sender as TButton).Caption);
end;
 
end.
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
