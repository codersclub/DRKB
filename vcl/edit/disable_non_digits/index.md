---
Title: Как заблокировать ввод нецифровых данных в Edit
Date: 01.01.2007
---


Как заблокировать ввод нецифровых данных в Edit
===============================================

Author: Krid

Source: <https://forum.sources.ru>

Блокировка вставки нецифровых данных через буфер обмена

    uses Clipbrd;
     
    function NewEditProc(wnd:HWND; uMsg:UINT; wParam:WPARAM; lParam:LPARAM):integer; stdcall;
    var
     s:string;
     i:integer;
    begin
     if (uMsg=WM_PASTE) and Clipboard.HasFormat(CF_TEXT) then
     begin
      s := Clipboard.AsText;
      for i:=1 to Length(s) do if (not (s[i] in ['0'..'9'])) then begin uMsg:=0; break end
     end;
     result:=CallWindowProc(Pointer(GetWindowLong(wnd,GWL_USERDATA)),wnd,uMsg,wParam,lParam)
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     SetWindowLong(Edit1.Handle,GWL_STYLE,GetWindowLong(Edit1.Handle,GWL_STYLE) or ES_NUMBER);
     SetWindowLong(Edit1.Handle,GWL_USERDATA,SetWindowLong(Edit1.Handle, GWL_WNDPROC, LPARAM(@NewEditProc)))
    end;


------------------------------------------------------------------------

Вариант 2:

Author: Vit

Следующий код создаёт TEdit который блокирует ввод любых нецифровых
данных при вводе любым способом.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    { Пример TEdit с выравниванием по центру © Song 
      в модификации Vit}
     
    type
     TForm1 = class(TForm)
       procedure FormCreate(Sender: TObject);
     private
       { Private declarations }
     public
       { Public declarations }
     end;
     
    { Обявляем класс нашего едита как потомок от стандартного}
    type TMySuperEdit=class(TCustomEdit)
    public
      { Внутри класса переопредялем процедуру CreateParams,
         т.к. нужный нам стиль можно изменить только на создании или пересоздании
         окна  }
     Procedure CreateParams(Var Params: TCreateParams); override;
    end;
     
    var
     Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    Procedure TMySuperEdit.CreateParams(Var Params: TCreateParams);
    Begin
     { Вызываем родительский обработчик, чтобы он сделал все процедуры по созданию объекта класса }
    inherited CreateParams(Params);
      { Изменяем стиль }
    With Params Do Style:=Style or ES_NUMBER;
    End;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     { Создаём едит на основе нашего класса и кладём его на форму }
    With TMySuperEdit.Create(Self) Do
      Parent:=Self;
    end;
    End.


------------------------------------------------------------------------

Вариант 3:

Author: Full (http://full.hotmail.ru/)

Source: <https://forum.sources.ru>

> Как сделать, чтобы TEdit воспринимал одни цифры и DecimalSeparator?

    type
      TNumEdit = class(TEdit)
      procedure CreateParams(var Params: TCreateParams); override;
      procedure KeyPress(var Key: Char); override;
    end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Standard', [TNumEdit]);
    end;
     
    procedure TNumEdit.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      Params.Style := Params.Style or ES_MULTILINE or ES_RIGHT;
    end;
     
    procedure TNumEdit.KeyPress(var Key: Char);
    begin
      case key of
      '0'..'9': ; // цифры
      #8: ; // забой
      '.', ',': if Pos(DecimalSeparator, Text)=0 then Key:=DecimalSeparator else Key:=#0; // десятичный разделитель
      else key:=#0;
      end; // case
    end;
     
    end.


------------------------------------------------------------------------

Вариант 4:

Посылаю Вам несколько расширенный вариант числовой маски компонента
TЕdit c помощью OnKeyPress. В отличие от имеющегося в "Советах",
приведенный код не "запирает" поле ввода при заполнении десятичной
части, преобразует точку в запятую (для удобства пользователя), не
позволяет поставить десятичную запятую перед числом и позволяет стирать
знаки в поле ввода клавишей \'Back Space\'. Код проверен в Delphi 5.

    procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
    var //цифровая маска
      vrPos, vrLength, vrSelStart: byte;
    const
      I: byte = 1;
        //I+1 = количество знаков после запятой (в данном случае - 2 знака)
    begin
     
      with Sender as TEdit do
      begin
        vrLength := Length(Text); //определяем длину текста
        vrPos := Pos(',', Text); //проверяем наличие запятой
        vrSelStart := SelStart; //определяем положение курсора
      end;
     
      case Key of
     
        '0'..'9':
          begin
            //проверяем положение курсора и количество знаков после запятой
            if (vrPos > 0) and (vrLength - vrPos > I) and (vrSelStart >= vrPos) then
              Key := #0; //"погасить" клавишу
          end;
        ',', '.':
          begin
            //если запятая уже есть или запятую пытаются поставить перед
            //числом или никаких цифр в поле ввода еще нет
            if (vrPos > 0) or (vrSelStart = 0) or (vrLength = 0) then
              Key := #0 //"погасить" клавишу
            else
              Key := #44; //всегда заменять точку на запятую
          end;
        #8: ; //позволить удаление знаков клавишей 'Back Space'
      else
        Key := #0; //"погасить" все остальные клавиши
      end;
    end; 

 

------------------------------------------------------------------------

Вариант 5:

Author: Vit

Все приведенные выше примеры грешат несколькими проблемами: одни из них
не учитывают ВСЕ способы которыми может вводится информация в TEdit -
одни не учитывают clipboard, другие ввод из кода программы, и наконец
все они не учитывают, что число может иметь например такую запись
"2E4" или даже "2E-4".

Попытка разрешить ситуацию привела к следующему простому коду:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Edit1: TEdit;
        procedure Edit1Change(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        EditValue:string;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Edit1Change(Sender: TObject);
      var selstart, sellength:integer;
    begin
      if Edit1.Text='' then
        begin
          Edit1.Text:='0';
          Edit1.SelStart:=1;
          Edit1.SelLength:=0;
          Exit;
        end;  
      try
        strtofloat(Edit1.Text);
        EditValue:=Edit1.Text;
      except
        selstart:=Edit1.SelStart;
        sellength:=Edit1.SelLength;
        Edit1.Text:=EditValue;
        Edit1.SelStart:=selstart;
        Edit1.SelLength:=sellength;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      EditValue:='0';
      Edit1.Text:=EditValue;
    end;
     
    end.

В данном коде в TEdit не получится вставить не цифровые данные. Можно
заменить строку

    strtofloat(Edit1.Text);

на

    strtoint(Edit1.Text);

для того чтобы ограничить возможность ввода только целыми числами.

