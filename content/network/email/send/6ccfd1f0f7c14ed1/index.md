---
Title: Использование COM-объекта Outlook
Author: Vit
Date: 01.01.2007
---


Использование COM-объекта Outlook
=================================

::: {.date}
01.01.2007
:::

Пример отсылки письма используя COM объект Outlook

    uses Outlook_TLB;
     

     
     
    var outlook : _application;
     
    Procedure Init;
    begin
      outlook := Coapplication_.Create;
    end;
     
    procedure SendEmail;
    begin
      with Outlook.CreateItem(olMailItem) as mailitem do
        begin
          To_ := 'email@email.com';
          cc:='email2@email.com';
          Subject := 'This is subject line';
          Attachments.Add('FileName',1,1,'This is attachment');
          Body :='This is email body';
          Send;
        end;
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Автор: Eddie Shipman

Пример использует VB Script для Outlook, который позволяет произвести
такую операцию. Создаётся OLE-объект - \'Outlook.Application\' и в него
передаётся скрипт.

Совместимость: все версии Delphi

Измените recipientaddress\@recipienthost.com на Ваш собственный e-mail

адресс. У Вас должен быть проинсталирован Outlook,

{Я не уверен, что это будет работать в Outlook Express.}

Примечание Vit: Это точно не будет работать в  Outlook Express

    uses ComObj; {Delphi 5} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    Const 
      // константы OlItemType 
      olMailItem = 0; 
      olAppointmentItem = 1; 
      olContactItem = 2; 
      olTaskItem  = 3; 
      olJournalItem = 4; 
      olNoteItem = 5; 
      olPostItem = 6; 
      // константы OlAttachmentType 
      olByValue = 1; 
      olByReference = 4; 
      olEmbeddedItem = 5; 
      olOLE = 6; 
     
    var 
      myOlApp, myItem, myRecipient, myAttachments: OleVariant; 
    begin 
      // файл VBScript для создания почтового сообщения и прикрепления к нему файла 
      myOlApp := CreateOLEObject('Outlook.Application'); 
      myItem := myOlApp.CreateItem(olMailItem); 
      myItem.Subject := 'This is the Subject'; 
      myRecipient := myItem.Recipients.Add('recipientaddress@recipienthost.com'); 
      myItem.Body := #13; 
      myItem.Body := myItem.Body + #13; 
      myItem.Body := myItem.Body + 'Hello,' + #13; 
      myItem.Body := myItem.Body + 'This code created this message and '+ 
                                   ' sent it and I didnt even have' + #13; 
      myItem.Body := myItem.Body + 'to click the send button!!!' + #13; 
      myItem.Body := myItem.Body + #13; 
      myItem.Body := myItem.Body + 'If you have any more problems, let me know' + 
    #13; 
      myItem.Body := myItem.Body + 'rename to blah.vbs and run like this:' + #13; 
      myItem.Body := myItem.Body + 'wscript c:\blah.vbs' + #13; 
      myItem.Body := myItem.Body + #13; 
      myItem.Body := myItem.Body + 'Eddie' + #13; 
      myItem.Body := myItem.Body + #13; 
      myItem.Body := myItem.Body + #13; 
      myItem.Body := myItem.Body + 'const'+ #13; 
      myItem.Body := myItem.Body + '  // константы OlItemType'+ #13; 
      myItem.Body := myItem.Body + '  olMailItem = 0;'+ #13; 
      myItem.Body := myItem.Body + '  olAppointmentItem = 1;'+ #13; 
      myItem.Body := myItem.Body + '  olContactItem = 2;'+ #13; 
      myItem.Body := myItem.Body + '  olTaskItem  = 3;'+ #13; 
      myItem.Body := myItem.Body + '  olJournalItem = 4;'+ #13; 
      myItem.Body := myItem.Body + '  olNoteItem = 5;'+ #13; 
      myItem.Body := myItem.Body + '  olPostItem = 6;'+ #13; 
      myItem.Body := myItem.Body + '  // OlAttachmentType constants'+ #13; 
      myItem.Body := myItem.Body + '  olByValue = 1;'+ #13; 
      myItem.Body := myItem.Body + '  olByReference = 4;'+ #13; 
      myItem.Body := myItem.Body + '  olEmbeddedItem = 5;'+ #13; 
      myItem.Body := myItem.Body + '  olOLE = 6;'+ #13; 
      myItem.Body := myItem.Body + #13; 
      myItem.Body := myItem.Body + 'var'+ #13; 
      myItem.Body := myItem.Body + '  myOlApp, myItem, myRecipient, myAttachments: 
    OleVariant;'+ #13; 
      myItem.Body := myItem.Body + 'begin'+ #13; 
      myItem.Body := myItem.Body + '  myOlApp := CreateObject(''Outlook.Application'')' + #13; 
      myItem.Body := myItem.Body + '  myItem := myOlApp.CreateItem(olMailItem)' + #13; 
      myItem.Body := myItem.Body + '  myItem.Subject := ''This is the Subject''' + #13; 
      myItem.Body := myItem.Body + '  myItem.Body := ''This is the body''' + #13;   
      myItem.Body := myItem.Body + '  myRecipient := myItem.Recipients.Add(''recipientaddress@recipienthost.com'')' + #13; 
      myItem.Body := myItem.Body + '  myAttachments := myItem.Attachments' + #13; 
      myItem.Body := myItem.Body + '  // Теперь прикрепим файлы...' + #13; 
      myItem.Body := myItem.Body + '  myAttachments.Add ''C:\blah.txt'', olByValue, 
    1, ''Blah.txt Attachment''' + #13; 
      myItem.Body := myItem.Body + '  myItem.Send' + #13; 
      myItem.Body := myItem.Body + '  myOlApp := VarNull;' + #13; 
      myItem.Body := myItem.Body + '  myItem := VarNull;' + #13; 
      myItem.Body := myItem.Body + '  myRecipient := VarNull;' + #13; 
      myItem.Body := myItem.Body + '  myAttachments := VarNull;' + #13; 
      myItem.Body := myItem.Body + 'end;' + #13; 
      // Теперь прикрепим файлы... 
      myAttachments := myItem.Attachments; 
      myAttachments.Add('C:\blah.txt', olByValue, 1, 'Blah.txt Attachment'); 
      myItem.Send 
      myOlApp := VarNull; 
      myItem := VarNull; 
      myRecipient := VarNull; 
      myAttachments := VarNull; 
    End; 
