<h1>Кодирование русского текста методом сдвига</h1>
<div class="date">01.01.2007</div>

Автор: ___Nikolay</p>
<pre>
unit uMain;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, ExtCtrls, ComCtrls, Spin;
 
type
  TForm1 = class(TForm)
    Panel1: TPanel;
    mmText: TMemo;
    Label1: TLabel;
    seN: TSpinEdit;
    Label2: TLabel;
    btEncode: TButton;
    btDecode: TButton;
    procedure btEncodeClick(Sender: TObject);
  private
    { Private declarations }
    procedure Encode(bCode: boolean; n: integer); // Encode - ПРОЦЕДУРА
                                                  // bCode  - зашифровать/расшифровать
                                                  // n      - шаг смещения
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
// ПРОЦЕДУРА КОДИРОВАНИЯ
procedure TForm1.Encode(bCode: boolean; n: integer);
const
  sMsgRangeErr = 'Значение шага должно быть от %d до %d!';
 
  // Крайние символы для кодирования
  chBigFirstLetter: char = 'А';
  chBigLastLetter: char = 'Я';
 
  chFirstLetter: char = 'а';
  chLastLetter: char = 'я';
var
  iMinOrd: integer; // Код символа с наименьшим кодом
  iMaxOrd: integer; // Код символа с наибольшим кодом
  i: integer; // Для фикла
  iTempOrd: integer; // Код подставляемого символа
  ch: char; // Каждый символ текста
  s: string; // Преобразуемый текст
begin
  // Проверка шага на диапазон допустимых значений
  if (n &gt; Ord(chBigLastLetter) - Ord(chBigFirstLetter)) or (n &lt; 1) then
  begin
    MessageDlg(Format(sMsgRangeErr, [1, Ord(chBigLastLetter) - Ord(chBigFirstLetter)]), mtError, [mbOk], 0);
    Exit;
  end;
 
  s := Trim(mmText.Text);
  if s &lt;&gt; '' then // Если есть текст
    for i := 1 to Length(s) do // Проходит каждый символ
    begin
      ch := s[i];
 
      // Если очередной символ нужно кодировать
      if ch in [chBigFirstLetter .. chBigLastLetter] then // Заглавные буквы
      begin
        iMinOrd := Ord(chBigFirstLetter);
        iMaxOrd := Ord(chBigLastLetter);
      end
      else
      if ch in [chFirstLetter .. chLastLetter] then // Строчные буквы
      begin
        iMinOrd := Ord(chFirstLetter);
        iMaxOrd := Ord(chLastLetter);
      end
      else // Символ кодировать не нужно
        continue;
 
      if bCode then // Закодировать
      begin
        iTempOrd := Ord(ch) + n; // Получаем потенциальную позицию
        if iMaxOrd - iTempOrd &lt; 0 then // Если символ зашел за границу предельного
          ch := Chr(iMinOrd + abs(iMaxOrd - iTempOrd) - 1) // Возьмем символ с другого конца круга
        else // Если нет..
          ch := chr(iTempOrd); //..все нормально
      end
      else // Раскодировать
      begin
        iTempOrd := Ord(ch) - n; // Получаем потенциальную позицию
        if iMinOrd - iTempOrd &gt; 0 then // Если символ зашел за границу предельного
          ch := Chr(iMaxOrd - (iMinOrd - iTempOrd - 1)) // Возьмем символ с другого конца круга
        else // Если нет..
          ch := chr(iTempOrd); //..все нормально
      end;
 
      s[i] := ch;
    end;
  mmText.Text := s;
end;
 
procedure TForm1.btEncodeClick(Sender: TObject);
begin
  Encode(boolean((Sender as TButton).Tag), seN.Value);
end;
 
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

