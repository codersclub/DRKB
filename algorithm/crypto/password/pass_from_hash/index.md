---
Title: Тянем пароли из кэша
Date: 01.01.2007
---


Тянем пароли из кэша
====================

::: {.date}
01.01.2007
:::

Так, сегодня мы рассмотрим как можно взять кэшированные пароли из 9x
винды, а также из винды, где в установленном виде есть 5-я иешка (хотя
может и 4-ой хватит:)

    unit Unit1;
     
    interface
     
    uses
      Windows, SysUtils, Classes, Forms, ShellAPI, Controls, StdCtrls;
     
    type
        TForm1 = class(TForm)
        GroupBox1: TGroupBox;
        ListBox: TListBox;
        Label1: TLabel;
        Label2: TLabel;
        procedure Label1Click(Sender: TObject);
        procedure FormShow(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
        hMPR: THandle;
    end;
     
    // Отсюда мы можем заключить что должно валяться на форме,
    // надеюсь вы сами всё закидаете, а если нет, то вам дорога в хелпы.
     
    var
      Form1: TForm1;
     
    const
      Count: Integer = 0;
     
    function WNetEnumCachedPasswords(lp: lpStr; w: Word; b: Byte;
    PC: PChar; dw: DWord): Word; stdcall;
     
    implementation
    {$R *.DFM}
     
    function WNetEnumCachedPasswords(lp: lpStr; w: Word; b: Byte;
    PC: PChar; dw: DWord): Word; external mpr name 'WNetEnumCachedPasswords';
     
    // Объявляем функцию внешней, надеюсь вы поняли
    // каким макаром, или вам опять в хелпы
     
    type
      PWinPassword = ^TWinPassword;
      TWinPassword = record
      EntrySize: Word;
      ResourceSize: Word;
      PasswordSize: Word;
      EntryIndex: Byte;
      EntryType: Byte;
      PasswordC: Char;
    end;
     
    // Объявляем все типы, которые будем юзать в проге.
     
    var
      WinPassword: TWinPassword;
     
    // Собственно переменные :-)
     
    function AddPassword(WinPassword: PWinPassword; dw: DWord): LongBool; stdcall;
    var
      Password: string;
      PC: array[0..$FF] of Char;
    begin
      inc(Count);
      // Увеличиваем число паролей на 1
      Move(WinPassword.PasswordC, PC, WinPassword.ResourceSize);
      // Получаем в PC пароль
      PC[WinPassword.ResourceSize] := #0;
      CharToOem(PC, PC);
      Password := StrPas(PC);
      // После недолгих преобразований в Password имеем кэшированный логин
      Move(WinPassword.PasswordC, PC, WinPassword.PasswordSize + WinPassword.ResourceSize);
      Move(PC[WinPassword.ResourceSize], PC, WinPassword.PasswordSize);
      PC[WinPassword.PasswordSize] := #0;< BR> CharToOem(PC, PC);
      // Теперь в PC имеем пароль
      Password := Password + ': ' + StrPas(PC);
      // Разделяем логин и пароль двуеточием...
      Form1.ListBox.Items.Add(Password);
      // ...и добавляем в ListBox на форме
      Result := True;
      // Возвращаемся с положительным результатом
    end;
     
    procedure TForm1.Label1Click(Sender: TObject);
    begin
      // при нажатии на лэйбл открываем окошко ие с нашим любимым сайтом :-)
      ShellExecute(GetDesktopWindow, 'open', 'http://www.lamerov.net', nil, nil, 0);
    end;
     
    procedure TForm1.FormShow(Sender: TObject);
    begin
      // А теперь сама процедура заполнения всех паролей.
      if WNetEnumCachedPasswords(nil, 0, $FF, @AddPassword, 0) <> 0 then
      // Если не найден кэшированый пароль, то
      begin
        Application.MessageBox('Cant load passwords: User is not logon.',
        'Error', mb_Ok or mb_IconWarning);
        Application.Terminate;
        // Выдаем сообщение об этом
      end
      // иначе,
      else
      if Count = 0 then
        // если паролей всего 0 то тоже об этом сообщаем
        ListBox.Items.Add('No passwords found...');
    end;
     
    end.

Вы наверное спросите: как же все таки дельфи попадает туда куда нам
нужно, то есть на функцию обработки паролей и почемы она кэшит их всех,
хотя функцию вызывали всего одни раз, а очень просто. Помните строку
WNetEnumCachedPasswords(nil, 0, $FF, @AddPassword, 0) так вот она все
и делает. Надеюсь вопросов не осталось.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
