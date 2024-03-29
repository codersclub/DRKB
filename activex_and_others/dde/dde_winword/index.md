---
Title: WinWord через DDE
Author: Jean Yves
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


WinWord через DDE
=================

Кто-нибудь пробовал использовать WinWord в качестве DDE-сервера?
Поделитесь результатами, если они, конечно, успешны.

Вариант 1:

Пара других пользователей также задавала на этой неделе аналогичный
вопрос, но у меня не было доступа к машине, где установлена Delphi. К
несчастью я затер их адреса, но надеюсь они увидят это сообщение.
Нижеприведенный код является "экстрактом" моей технологии, которую я
успешно применил для создания DDEPokes и DDEExecutes с WinWord в
качестве сервера. Обратите внимание на то, что я использовал методы DDE,
требующие PChar вместо строк, поскольку строки имеют дополнительные
символы и при DDE-преобразованиях WinWord\'у плохеет.

    function TfrmLetter.CreateLetter: Boolean;
    var
      szCommand: array[0..2048] of char;
      sCommand: string;
      BmkNames: array[0..3] of string;
      idx: ShortInt;
      DDEOK: Boolean;
      Buffer, ParMark: PChar;
      BufSize: Integer;
      hWord: hWnd;
    begin
      CreateLetter := False;
      DDEOK := True; {Флаг проверки результатов DDE-операций}
      DDEClient.SetLink('winword', WordDoc);
        {WordDoc содержит имя документа winword, необходимого для связи}
      {DDEClient - элемент управления DDE client}
      if DDEClient.OpenLink = False then
        Exit;
     
      hWord := FindWindow('OpusApp', nil);
      LockWindowUpdate(hWord); {Блокируем обновление экрана winword}
     
      {Убедитесь, что нужный документ является активным окном Word}
      sCommand := '[If FileName$() <> "' + WordDoc + '" Then]';
      sCommand := sCommand + '[While (idx < CountWindows()) and (FileName$() <> "';
      sCommand := sCommand + WordDoc + '")][NextWindow][idx = idx + 1]';
      sCommand := sCommand + '[Wend][Activate WindowName$()][End If]';
      StrPLCopy(szCommand, sCommand, SizeOf(szCommand) - 1);
      DDEOK := DDEOK and DDEClient.ExecuteMacro(szCommand, False);
     
      {Сбрасываем баннер}
      sCommand := '[EditGoto "Banner"]';
      if GetWinwordVersion = 2 then
        {GetWinword - простая функция пользователя, использующая GetModuleHandle
        для определения номера версии запущенного Word: Word 2 или Word 6}
        sCommand := sCommand + '[EditGlossary "Banner"]'
      else if GetWinwordVersion = 6 then
        sCommand := sCommand + '[EditAutoText "Banner"]';
      sCommand := sCommand + '[EditGoto "Date"][UpdateFields][LockFields]';
      StrPLCopy(szCommand, sCommand, SizeOf(szCommand) - 1);
      DDEOK := DDEOK and DDEClient.ExecuteMacro(szCommand, False);
      Application.ProcessMessages;
     
      {Вставляем Имя отправителя, Прямой номер абонента и пр.}
      BmkNames[0] := 'DirectDialNumber';
      BmkNames[1] := 'EMailAddress';
      BmkNames[2] := 'AuthorName';
      BmkNames[3] := 'Personal';
      for idx := 0 to 3 do
        if CheckInclude[idx].Checked = True then
        begin
          BufSize := TextInclude[idx].GetTextLen;
          Inc(BufSize);
          GetMem(Buffer, BufSize);
          TextInclude[idx].GetTextBuf(Buffer, BufSize);
          DDEOK := DDEOK and DDEClient.PokeData(BmkNames[idx], Buffer);
          FreeMem(Buffer, BufSize);
        end
        else
          DDEOK := DDEOK and DDEClient.PokeData(BmkNames[idx] + '2', '');

и так далее.

--------------------------------------------------

Вариант 2:

Вот еще очень простой пример DDE-связи с WinWord 6. Это работает.

В Word вы должны иметь заранее созданный файл (в нашем примере
DDETEST.DOC) и закладку с именем "Bm1".

    unit Unit1;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, DdeMan;
     
    type
     
      TForm1 = class(TForm)
        DdeConv: TDdeClientConv;
        Word: TButton;
        procedure WordClick(Sender: TObject);
      private
        { Private-declarations }
      public
        { Public-declarations }
      end;
     
      {  Свойства DdeConv:       }
      {  ConnectMode : ddeManual }
      {  DdeService : [None]     }
      {  DdeTopic    : [None]    }
      {  FormatChars : False     }
      {  Name        : DdeConv   }
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.WordClick(Sender: TObject);
    begin
     
      if DdeConv.SetLink('WINWORD', 'D:\WINWORD\DDETEST') and
        DdeConv.OpenLink then
      begin
        ShowMessage('Установлена связь с WinWord !')
          { убедимся в наличии соединения }
        DdeConv.PokeData('Bm1', 'Данные из Delphi !')
          { вставляем 'Данные из Delphi' в документ word }
        DdeConv.CloseLink;
      end;
    end;
     
    end.

Но только сделав это хотя бы раз своими руками, вы сможете разобраться в
этой технологии


