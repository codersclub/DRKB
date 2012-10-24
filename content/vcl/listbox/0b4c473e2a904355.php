<h1>Инкрементальный поиск в TListBox</h1>
<div class="date">01.01.2007</div>


<p>Я видел приложение, в котором ListBox позволял осуществлять инкрементальный поиск. При вводе очередного символа он позиционирует вас к первой ячейке, начало значения которой совпадает с введенным пользователем текстом, или выделяет все строки с текстом, содержащим введенный текст.</p>
<p>Как это осуществить на Delphi?</p>
<p>Здесь придется немного воспользоваться Win API. Установите свойство формы KeyPreview в True и сделайте примерно следующее:</p>
<pre>
unit LbxSrch;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Controls, Forms, StdCtrls;
 
type
  TFrmLbxSrch = class(TForm)
    Edit1: TEdit;
    Edit2: TEdit;
    ListBox1: TListBox;
    Label1: TLabel;
    procedure FormKeyPress(Sender: TObject; var Key: Char);
    procedure ListBox1Enter(Sender: TObject);
  private { Private declarations }
    FPrefix: array[0..255] of char;
  public
    { Public declarations }
  end;
 
var
  FrmLbxSrch: TFrmLbxSrch;
 
implementation
 
{$R *.DFM}
 
procedure TFrmLbxSrch.FormKeyPress(Sender: TObject; var Key: Char);
{ Помните о том, что свойство KeyPreview должно быть установлено в True }
var
  curKey: array[0..1] of char;
  ndx: integer;
begin
  if ActiveControl = ListBox1 then
  begin
    if key = #8 {Backspace (клавиша возврата)} then
    begin
      if FPrefix[0] &lt;&gt; #0 then
      begin
        FPrefix[StrLen(FPrefix) - 1] := #0;
      end
    end
    else
    begin
      curKey[0] := Key;
      curKey[1] := #0;
      StrCat(FPrefix, curKey);
      ndx := SendMessage(ListBox1.Handle, LB_FINDSTRING,
        -1, longint(@FPrefix));
      if ndx &lt;&gt; LB_ERR then
        ListBox1.ItemIndex := ndx;
    end;
 
    Label1.Caption := StrPas(FPrefix);
    Key := #0;
  end;
end;
 
procedure TFrmLbxSrch.ListBox1Enter(Sender: TObject);
begin
  FPrefix[0] := #0;
  Label1.Caption := StrPas(FPrefix);
end;
 
end.
</pre>

<div class="author">Автор: Ralph Friedman</div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<hr /><p>Предположим, что ListBox сортируется, это не трудно. Вы должны разместить компонент Edit выше ListBox и создать следующий обработчик его случая OnChange:</p>
<pre>
procedure TForm1.Edit1Change(Sender: TObject);
var
  Ndx: Word;
begin
  with Sender as TEdit do
  begin
    Ndx := ListBox1.Items.Add(Text);
    ListBox1.Items.Delete(Ndx);
    if CompareText(Text, Copy(ListBox1.Items[Ndx], 1, Length(Text))) = 0 then
      ListBox1.ItemIndex := Ndx
    else
      ListBox1.ItemIndex := -1;
  end;
end;
</pre>

<p>Пытаясь вставить часть текста, вы просто просматриваете список на предмет его наличия. Если актуальный элемент в этой позиции содержит "частичный" текст, мы выводим его, в противном случае делаем так, чтобы ListBox не имел выделенного (ItemIndex) элемента.</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
