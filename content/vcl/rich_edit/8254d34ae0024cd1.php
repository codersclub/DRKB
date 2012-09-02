<h1>Таблицу в Clipboard</h1>
<div class="date">01.01.2007</div>


<p>У меня есть 2 memo. как мне сделать так, чтобы в клипборд посылалосьтабличка из двух ячеек с содержимым их мемо. точнее как загнать табличку в клипборд программно.</p>
<p>Я смотрел, что когда копируешь из wordа табличку, то в клипе лежит текст и картинка (вот с эти я больше всего не понял). Не понятно!! </p>
<p>Итак во-первых</p>
<p>Мутим такую программку</p>
<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, Clipbrd, ComCtrls;
 
type
  TForm1 = class(TForm)
    memformats: TMemo;
    memexample: TMemo;
    Label1: TLabel;
    BtnShowFormats: TButton;
    btngetrtf: TButton;
    btnsetrtf: TButton;
    RichEdit1: TRichEdit;
    procedure FormCreate(Sender: TObject);
    procedure BtnShowFormatsClick(Sender: TObject);
    procedure btngetrtfClick(Sender: TObject);
    procedure btnsetrtfClick(Sender: TObject);
  private
    { Private declarations }
  public
    CF_RTF: Word;
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.FormCreate(Sender: TObject);
begin  
  // register clipboard format rtf  
  CF_RTF := RegisterClipboardFormat('Rich Text Format');  
  if CF_RTF = 0 then  
  begin  
    ShowMessage('Unable to register the Rich Text clipboard format!');  
    Application.Terminate;  
  end;
  BtnShowFormats.Click;
end;
 
procedure TForm1.BtnShowFormatsClick(Sender: TObject);
var  
  buf: array [0..60] of Char;  
  n: Integer;  
  fmt: Word;  
  Name: string[30];  
begin  
  MemFormats.Clear;  
  for n := 0 to Clipboard.FormatCount - 1 do
  begin  
    fmt := Clipboard.Formats[n];
    if GetClipboardFormatName(fmt, buf, Pred(SizeOf(buf))) &lt;&gt; 0 then  
      MemFormats.Lines.Add(StrPas(buf))  
    else  
    begin  
      case fmt of  
        1: Name := 'CF_TEXT';  
        2: Name := 'CF_BITMAP';  
        3: Name := 'CF_METAFILEPICT';  
        4: Name := 'CF_SYLK';  
        5: Name := 'CF_DIF';  
        6: Name := 'CF_TIFF';  
        7: Name := 'CF_OEMTEXT';  
        8: Name := 'CF_DIB';  
        9: Name := 'CF_PALETTE';  
        10: Name := 'CF_PENDATA';  
        11: Name := 'CF_RIFF';  
        12: Name := 'CF_WAVE';  
        13: Name := 'CF_UNICODETEXT';  
        14: Name := 'CF_ENHMETAFILE';  
        15: Name := 'CF_HDROP (Win 95)';  
        16: Name := 'CF_LOCALE (Win 95)';  
        17: Name := 'CF_MAX (Win 95)';  
        $0080: Name := 'CF_OWNERDISPLAY';  
        $0081: Name := 'CF_DSPTEXT';  
        $0082: Name := 'CF_DSPBITMAP';  
        $0083: Name := 'CF_DSPMETAFILEPICT';  
        $008E: Name := 'CF_DSPENHMETAFILE';  
        $0200..$02FF: Name := 'private format';  
        $0300..$03FF: Name := 'GDI object';  
        else  
          Name := 'unknown format';  
      end;  
      MemFormats.Lines.Add(Name);  
    end;
  end;  
end;
 
procedure TForm1.btngetrtfClick(Sender: TObject);
var  
  MemHandle: THandle;  
begin  
  with Clipboard do  
  begin  
    Open;  
    try  
      if HasFormat(CF_RTF) then  
      begin  
        MemHandle := GetAsHandle(CF_RTF);
        MemExample.SetTextBuf(GlobalLock(MemHandle));
        GlobalUnlock(MemHandle);  
      end  
      else  
        MessageDlg('The clipboard contains no RTF text!',  
          mtError, [mbOK], 0);  
    finally  
      Close;  
    end;
  end;  
end;
 
procedure TForm1.btnsetrtfClick(Sender: TObject);
const  
  testtext: PChar = '{\rtf1\ansi\pard\plain 12{\ul 44444}}';  
  testtext2: PChar = '{\rtf1\ansi' +  
    '\deff4\deflang1033{\fonttbl{\f4\froman\fcharset0\fprq2 Times New Roman Cyr;}}' +  
    '\pard\plain 12{\ul апопьт4}}';
var
  MemHandle: THandle;
  rtfstring: PChar;
begin
 
  with Clipboard do
  begin
    rtfstring :=memexample.Lines.GetText;
//    rtfstring :=testtext;
    MemHandle := GlobalAlloc(GHND or GMEM_SHARE, StrLen(rtfstring) + 1);  
    if MemHandle &lt;&gt; 0 then  
    begin  
      StrCopy(GlobalLock(MemHandle), rtfstring);
      GlobalUnlock(MemHandle);
      Open;  
      try  
       // AsText := '1244444';
        SetAsHandle(CF_RTF, MemHandle);
      finally  
        Close;  
      end;  
    end  
    else  
      MessageDlg('Global Alloc failed!',
        mtError, [mbOK], 0);  
  end;
end;
end.
</pre>

<p>прога представляет из себя просмоторщик rtf-текста в буфере. Из вёрда допустим, копируем табличку, нажимает на кнопочку(btngetrtf) в проге и в memo высветится наш клипборд </p>
<p>Точнее из этой проги, в основном нам нужна процедура копирования в буфер, благополучно ее и забираем, а также то, что получается в буфере. </p>
<p>во-вторых, рисуем таблицу в вёрде, копируем в клипбоАрд. Запускаем нашу прогу и нажимаем на нопочку (btngetrtf) и нам, О чудо!!!, высвечивается буфер. То, что вы там увидите, будет очень громоздко по размерам и переполнено тегами. Для своего случая, мне нужна была небольшая табличка 4х2, я сначала копировал из вёдра, потом копировал в wordpad, и сохранял на диск. Там реально в чем-то разобраться, нежели чем из вёрда. Такой фокус прокатит только с объединенными ячейками по горизонтали, по вертикали не судьба.</p>
<p>В-третьих, чтобы мало по малу отредактировать наш rtf или понять что и где находится изучаем его спецификацию <a href="https://ftp.bspu.unibel.by/pub/Programming/Specifications/rtf/gc0165.exe" target="_blank">https://ftp.bspu.unibel.by/pub/Programming/Specifications/rtf/gc0165.exe</a> . Что-нибудь редактируем. Вот мы получили содержимое нашего буфера. Теперь рисуем свою прогу, туда процедуру копирования в буфер, и содержимое нашего буфера. </p>
<p class="author">Автор: andruxin </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

