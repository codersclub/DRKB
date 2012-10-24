<h1>}{0TT@БЬIЧ</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Александр</div>
<pre>
unit Stilizator;
 
interface
 
uses
  Windows, Messages,  Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, XPMan;
 
type
  TForm1 = class(TForm)
    MemoSource: TMemo;
    MemoDest: TMemo;
    Button: TButton;
    XPManifest1: TXPManifest;
    procedure ButtonClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
 
  private
    { Private declarations }
  public
    procedure ConvertText(Letter: String);
  end;
 
var
  Form1: TForm1;
  RS : Array [0..65] of String;
  PRS : Array [0..65] of String;
  ES : Array [0..51] of String;
  PPS : Array [0..51] of String;
 
implementation
 
uses AboutUnit;
 
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
RS[0]:='а'; PRS[0]:='@';
RS[1]:='б'; PRS[1]:='6';
RS[2]:='в'; PRS[2]:='B';
RS[3]:='г'; PRS[3]:='r';
RS[4]:='д'; PRS[4]:='g';
RS[5]:='е'; PRS[5]:='e';
RS[6]:='ё'; PRS[6]:='e';
RS[7]:='ж'; PRS[7]:='}|{';
RS[8]:='з'; PRS[8]:='3';
RS[9]:='и'; PRS[9]:='u';
RS[10]:='й'; PRS[10]:='u';
RS[11]:='к'; PRS[11]:='k';
RS[12]:='л'; PRS[12]:='JI';
RS[13]:='м'; PRS[13]:='M';
RS[14]:='н'; PRS[14]:='H';
RS[15]:='о'; PRS[15]:='o';
RS[16]:='п'; PRS[16]:='n';
RS[17]:='р'; PRS[17]:='p';
RS[18]:='с'; PRS[18]:='c';
RS[19]:='т'; PRS[19]:='T';
RS[20]:='у'; PRS[20]:='y';
RS[21]:='ф'; PRS[21]:='%';
RS[22]:='х'; PRS[22]:='x';
RS[23]:='ц'; PRS[23]:='?';
RS[24]:='ч'; PRS[24]:='4';
RS[25]:='ш'; PRS[25]:='III';
RS[26]:='щ'; PRS[26]:='III,';
RS[27]:='ъ'; PRS[27]:='b';
RS[28]:='ы'; PRS[28]:='bI';
RS[29]:='ь'; PRS[29]:='b';
RS[30]:='э'; PRS[30]:='&amp;';
RS[31]:='ю'; PRS[31]:='I-o';
RS[32]:='я'; PRS[32]:='9I';
RS[33]:='А'; PRS[33]:='A';
RS[34]:='Б'; PRS[34]:='6';
RS[35]:='В'; PRS[35]:='B';
RS[36]:='Г'; PRS[36]:='r';
RS[37]:='Д'; PRS[37]:='g';
RS[38]:='Е'; PRS[38]:='E';
RS[39]:='Ё'; PRS[39]:='E';
RS[40]:='Ж'; PRS[40]:='}|{';
RS[41]:='З'; PRS[41]:='3';
RS[42]:='И'; PRS[42]:='U';
RS[43]:='Й'; PRS[43]:='U';
RS[44]:='К'; PRS[44]:='K';
RS[45]:='Л'; PRS[45]:='JL';
RS[46]:='М'; PRS[46]:='M';
RS[47]:='Н'; PRS[47]:='H';
RS[48]:='О'; PRS[48]:='O';
RS[49]:='П'; PRS[49]:='n';
RS[50]:='Р'; PRS[50]:='p';
RS[51]:='С'; PRS[51]:='c';
RS[52]:='Т'; PRS[52]:='T';
RS[53]:='У'; PRS[53]:='Y';
RS[54]:='Ф'; PRS[54]:='%';
RS[55]:='Х'; PRS[55]:='X';
RS[56]:='Ц'; PRS[56]:='?';
RS[57]:='Ч'; PRS[57]:='4';
RS[58]:='Ш'; PRS[58]:='III';
RS[59]:='Щ'; PRS[59]:='III,';
RS[60]:='Ъ'; PRS[60]:='b';
RS[61]:='Ы'; PRS[61]:='bI';
RS[62]:='Ь'; PRS[62]:='b';
RS[63]:='Э'; PRS[63]:='&amp;';
RS[64]:='Ю'; PRS[64]:='I-O';
RS[65]:='Я'; PRS[65]:='9I';
ES[0]:='a'; PPS[0]:='@';
ES[1]:='b'; PPS[1]:='6';
ES[2]:='c'; PPS[2]:='|_|,';
ES[3]:='d'; PPS[3]:=',^,';
ES[4]:='e'; PPS[4]:='e';
ES[5]:='f'; PPS[5]:='%';
ES[6]:='g'; PPS[6]:='|"';
ES[7]:='h'; PPS[7]:='][';
ES[8]:='i'; PPS[8]:='|/|';
ES[9]:='j'; PPS[9]:='&gt;|&lt;';
ES[10]:='k'; PPS[10]:='K';
ES[11]:='l'; PPS[11]:='/\';
ES[12]:='m'; PPS[12]:='M';
ES[13]:='n'; PPS[13]:='|-|';
ES[14]:='o'; PPS[14]:='0';
ES[15]:='p'; PPS[15]:='n';
ES[16]:='q'; PPS[16]:='k|3';
ES[17]:='r'; PPS[17]:='P';
ES[18]:='s'; PPS[18]:='$';
ES[19]:='t'; PPS[19]:='T';
ES[20]:='u'; PPS[20]:='Y';
ES[21]:='v'; PPS[21]:='\/';
ES[22]:='w'; PPS[22]:='|3';
ES[23]:='x'; PPS[23]:='kc';
ES[24]:='y'; PPS[24]:='9';
ES[25]:='z'; PPS[25]:='3';
ES[26]:='A'; PPS[26]:='@';
ES[27]:='B'; PPS[27]:='6';
ES[28]:='C'; PPS[28]:='|_|,';
ES[29]:='D'; PPS[29]:=',^,';
ES[30]:='E'; PPS[30]:='E';
ES[31]:='F'; PPS[31]:='%';
ES[32]:='G'; PPS[32]:='|"';
ES[33]:='H'; PPS[33]:='}{';
ES[34]:='I'; PPS[34]:='|/|';
ES[35]:='J'; PPS[35]:='&gt;|&lt;';
ES[36]:='K'; PPS[36]:='K';
ES[37]:='L'; PPS[37]:='/\';
ES[38]:='M'; PPS[38]:='M';
ES[39]:='N'; PPS[39]:='|-|';
ES[40]:='O'; PPS[40]:='0';
ES[41]:='P'; PPS[41]:='n';
ES[42]:='Q'; PPS[42]:='K|3';
ES[43]:='R'; PPS[43]:='P';
ES[44]:='S'; PPS[44]:='$';
ES[45]:='T'; PPS[45]:='T';
ES[46]:='U'; PPS[46]:='Y';
ES[47]:='V'; PPS[47]:='\/';
ES[48]:='W'; PPS[48]:='|3';
ES[49]:='X'; PPS[49]:='][';
ES[50]:='Y'; PPS[50]:='9';
ES[51]:='Z'; PPS[51]:='3';
 
end;
 
procedure TForm1.ButtonClick(Sender: TObject);
var
  i : Integer;
  Letter : String;
begin
  MemoDest.Clear;
  for i := 0 to MemoSource.GetTextLen - 1 do begin
    MemoSource.SelStart := i;
    MemoSource.SelLength := 1;
    Letter := MemoSource.SelText;
    ConvertText(Letter);
    Sleep(5)
    end;
 
 
  MemoSource.SelLength := 0;
end;
 
procedure TForm1.ConvertText(Letter: String);
var
  i : Integer;
begin
  for i := 0 to 65 do begin
    if Letter = RS[i] then
      Letter := PRS[i];
  end;
  for i := 0 to 51 do begin
    if Letter = ES[i] then
      Letter := PPS[i];
  end;
  MemoDest.Text := MemoDest.Text + Letter;
end;
 
end.
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

