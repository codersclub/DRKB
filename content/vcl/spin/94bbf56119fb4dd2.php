<h1>TEdit с возможностью автоматического выбора</h1>
<div class="date">01.01.2007</div>

...маленький компонент THintEdit, порожденный от TCustomEdit, который представляет собой с виду обычный TEdit элемент с возможностью автоматического выбора стринговых значений из скрытого списка (так, как это реализовано в Netscape Navigator'е). Описание особенно не нужно, так как выполнено все достаточно элементарно: значения для выбора заносятся в свойство HintList, тип свойства TStrings. При нажатии клавиш вверх/вниз выбираются значения, соответствующие набранным начальным символам.</p>
<pre>
unit HintEdit;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls;
 
type
  THintEdit = class(TCustomEdit)
  private
    { Private declarations }
    FHintList: TStrings;
    Searching,
      CanSearch: boolean;
    CurSPos: integer;
  protected
    { Protected declarations }
    procedure Change; override;
    procedure KeyDown(var Key: Word; Shift: TShiftState); override;
  public
    { Public declarations }
    constructor Create(AOwner: TComponent); override;
    property HintList: TStrings read FHintList write FHintList;
    destructor Destroy; override;
  published
    { Published declarations }
    property Anchors;
    property AutoSelect;
    property AutoSize;
    property BiDiMode;
    property BorderStyle;
    property CharCase;
    property Color;
    property Constraints;
    property Ctl3D;
    property DragCursor;
    property DragKind;
    property DragMode;
    property Enabled;
    property Font;
    property HideSelection;
    property ImeMode;
    property ImeName;
    property MaxLength;
    property OEMConvert;
    property ParentBiDiMode;
    property ParentColor;
    property ParentCtl3D;
    property ParentFont;
    property ParentShowHint;
    property PasswordChar;
    property PopupMenu;
    property ReadOnly;
    property ShowHint;
    property TabOrder;
    property TabStop;
    property Text;
    property Visible;
    property OnChange;
    property OnClick;
    property OnDblClick;
    property OnDragDrop;
    property OnDragOver;
    property OnEndDock;
    property OnEndDrag;
    property OnEnter;
    property OnExit;
    property OnKeyDown;
    property OnKeyPress;
    property OnKeyUp;
    property OnMouseDown;
    property OnMouseMove;
    property OnMouseUp;
    property OnStartDock;
    property OnStartDrag;
  end;
 
procedure Register;
 
implementation
 
{$R *.DCR}
 
procedure Register;
begin
  RegisterComponents('Netscape', [THintEdit]);
end;
 
constructor THintEdit.Create;
begin
  inherited;
  FHintList := TStringList.Create;
  Searching := false;
  CanSearch := true;
  CurSPos := -1;
end;
 
procedure THintEdit.Change;
var
  i, l: integer;
begin
  if Searching then
    Exit;
  if not CanSearch then
    Exit;
  if Text = '' then
    exit;
  l := Length(Text);
  for i := 0 to FHintList.Count - 1 do
    if Copy(FHintList[i], 1, l) = Text then
    begin
      Searching := true;
      CurSPos := i;
      Text := FHintList[i];
      Searching := false;
      SelStart := Length(Text);
      SelLength := -(Length(Text) - l);
      break;
    end;
  inherited;
end;
 
procedure THintEdit.KeyDown;
var
  l: integer;
begin
  if Chr(Key) in ['A'..'z', 'А'..'Я', 'а'..'я'] then
    CanSearch := true
  else
    CanSearch := false;
  case Key of
    VK_DOWN:
      begin
        if (CurSPos &lt; HintList.Count - 1) and (SelLength &gt; 0) then
          if Copy(FHintList[CurSPos + 1], 1, SelStart) = Copy(Text, 1, SelStart)
            then
          begin
            l := SelStart;
            Inc(CurSPos);
            Text := FHintList[CurSPos];
            SelStart := Length(Text);
            SelLength := -(Length(Text) - l);
          end;
        Key := VK_RETURN;
      end;
    VK_UP:
      begin
        if (CurSPos &gt; 0) and (SelLength &gt; 0) then
          if Copy(FHintList[CurSPos - 1], 1, SelStart) = Copy(Text, 1, SelStart)
            then
          begin
            l := SelStart;
            Dec(CurSPos);
            Text := FHintList[CurSPos];
            SelStart := Length(Text);
            SelLength := -(Length(Text) - l);
          end;
        Key := VK_RETURN;
      end;
    VK_RETURN:
      begin
        SelStart := 0;
        SelLength := Length(Text);
      end;
  end;
  inherited;
end;
 
destructor THintEdit.Destroy;
begin
  FHintList.Free;
  inherited;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
<p>Подстановка в TEdit </p>
<pre>
var
  words: TStringList;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  words := TStringList.Create;
  words.Sorted := true;
  words.Add('one');
  words.Add('two');
  words.Add('four');
  words.Add('five');
  words.Add('six');
  words.Add('seven');
  words.Add('eight');
  words.Add('nine');
  words.Add('ten');
end;
 
procedure TForm1.Edit1KeyUp(Sender: TObject; var Key: Word;
Shift: TShiftState);
const
  chars: set of char = ['A'..'Z', 'a'..'z', 'А'..'Я', 'а'..'я'];
var
  w: string;
  i: integer;
  s: string;
  full: string;
  SelSt: integer;
begin
  case Key of
    VK_RETURN, VK_TAB:
    begin
      Edit1.SelStart := Edit1.SelStart + Edit1.SelLength;
      Edit1.SelLength := 0;
      Exit;
    end;
    VK_DELETE, VK_BACK:
    begin
      Edit1.ClearSelection;
      Exit;
    end;
  end;
  s := Edit1.Text;
  SelSt := Edit1.SelStart;
  i := SelSt;
  if (length(s) &gt; i) and (s[i+1] in chars) then
    Exit;
  w := '';
  while (i &gt;= 1) and (s[i] in chars) do
  begin
    w := s[i] + w;
    dec(i);
  end;
  if length(w) &lt;= 0 then
    Exit;
  words.Find(w, i);
  if (i &gt;= 0) and (UpperCase(copy(words[i], 1,
  length(w))) = UpperCase(w)) then
  begin
    full := words[i];
    insert(copy(full, length(w) + 1, length(full)), s, SelSt + 1);
    Edit1.Text := s;
    Edit1.SelStart := SelSt;
    Edit1.SelLength := length(full) - length(w);
  end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

