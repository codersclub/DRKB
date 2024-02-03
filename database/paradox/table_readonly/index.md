---
Title: Доступ к таблицам Paradox на CD или c флагом только для чтения
Date: 01.01.2007
---


Доступ к таблицам Paradox на CD или c флагом только для чтения
==============================================================

::: {.date}
01.01.2007
:::

Данный совет поможет вам разобраться в таком вопросе, как доступ к
таблицам Paradox, расположенным на CD-ROM или диске, имеющем флаг
"только для чтения".

Механиз блокирования файлов Paradox требует наличие файла PDOXUSRS.LCK,
осуществляющий логику работы блокировки. Данный файл обычно создается во
время выполнения приложения и располагается в том же каталоге, где и
таблицы. Тем не менее, в случае с CD-ROM, во время выполнения программы
нет никакой возможности создать на нем описанный выше файл. Решение
простое: мы создаем этот файл и помещаем его на CD-ROM во время его (CD)
создания. Следующая простейшая программка позволит создать вам файл
PDOXUSRS.LCK и поместить его в образ компакта для его последующего
копирования на CD-ROM:

Стартуйте пустой проект и добавьте на форму следующие компоненты: TEdit,
TButton и TDatabase.

В обработчике кнопки OnClick используйте следующий код:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if ChkPath then
        Check(DbiAcqPersistTableLock(Database1.Handle,
          'PARADOX.DRO','PARADOX'));
    end;

Функция ChkPath является методом, определенным пользователем для формы.
Она просто проверяет путь, введенный пользователем в поле редактирования
и убеждается, что он существует. Вот функция:

    function TForm1.ChkPath: Boolean;
    var
      s: array[0..100] of char;
    begin
      if DirectoryExists(Edit1.Text) then
        begin
          DataBase1.DatabaseName := 'TempDB';
          DataBase1.DriverName := 'Standard';
          DataBase1.LoginPrompt := false;
          DataBase1.Connected := False;
          DataBase1.Params.Add('Path=' + Edit1.Text);
          DataBase1.Connected := TRUE;
          Result := TRUE;
        end
      else
        begin
          StrPCopy(s, 'Каталог : ' + Edit1.text + ' не найден');
          Application.MessageBox(s, 'Ошибка!', MB_ICONSTOP);
          Result := FALSE;
        end;
    end;
     
    { Примечание: Не забудьте добавить объявление
      функции в секцию public формы. }

Перед компиляцией необходимо вспомнить еще об одной вещи: в список Uses
нужно добавить следующие модули:

Delphi 1.0: FileCtrl, DbiProcs, DbiTypes, DbiErrs.

Delphi 2.0: FileCtrl, BDE

После компиляции и выполнения, программа создаст два файла в
определенном вами каталоге. Создаваемые два файла: PDOXUSRS.LCK и
PARADOX.LCK.

Примечание

Файл PARADOX.LCK необходим только для доступа к таблицам Paradox for
DOS, так что вы можете его удалить.

Вам осталась сделать только одну последнюю вещь: скопировать оставшийся
файл (PDOXUSRS.LCK) в образ CD-ROM. Естественно, ваши таблицы будут
только для чтения.

Примечание

Если вы собираетесь довольно часто пользоваться данной утилитой, то для
удобства вы можете изменить свойство Text компонента Edit на ваш
"любимый" каталог, а свойство Caption кнопки поменять на что-нибудь
более "интеллектуальное".

Вот окончательная версия кода:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, DB, StdCtrls, FileCtrl,
     
    {$IFDEF WIN32}
      BDE;
    {$ELSE}
      DbiProcs, DbiTypes, DbiErrs;
    {$ENDIF }
     
    type
      TForm1 = class(TForm)
        Edit1: TEdit;
        Button1: TButton;
        Database1: TDatabase;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
        function ChkPath: Boolean;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    function TForm1.ChkPath: Boolean;
    var
      s: array[0..100] of char;
    begin
      if DirectoryExists(Edit1.Text) then
        begin
          DataBase1.DatabaseName := 'TempDB';
          DataBase1.DriverName := 'Standard';
          DataBase1.LoginPrompt := false;
          DataBase1.Connected := False;
          DataBase1.Params.Add('Path=' + Edit1.Text);
          DataBase1.Connected := TRUE;
          Result := TRUE;
        end
      else
        begin
          StrPCopy(s, 'Каталог : ' + Edit1.text + ' не найден');
          Application.MessageBox(s, 'Ошибка!', MB_ICONSTOP);
          Result := FALSE;
        end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if ChkPath then
        Check(DbiAcqPersistTableLock(Database1.Handle,
          'PARADOX.DRO', 'PARADOX'));
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>
