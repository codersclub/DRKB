---
Title: TRichEdit сам меняет язык при перемещении
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


TRichEdit сам меняет язык при перемещении
=========================================

Самое главное, что мне НЕ нравится в Richedit - это то, что он сам
меняет язык при перемещении по тексту, несмотря на то, что вы включили нужный
язык, при переходе на участок текста, набраный другим языком.

этот баг я обхожу так:

я создаю потомка Richedit:

меню Component\\New Component указываю предком TRichedit.

Переписываю обработку события WM\_INPUTLANGCHANGE, при этом я не вызываю
обработчик предка, т.е. Richedit-а.

Заодно обрабатываю событие WM\_INPUTLANGCHANGEREQUEST, которое сообщает,
что пользователь изменил язык. Тут надо вызвать обработчик предка, а то
не будет переключаться язык.

Вот что из этого получилось. Имеем исправленный компонент VCL с
дополнительным событием.

    unit RichEditEx;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ComCtrls;
     
    type
      TLangChangeEvent = procedure(Sender: TObject; Lang: HKL) of object;
     
      TRichEditEx = class(TRichEdit)
      private
        FOnLangChange: TLangChangeEvent;
        procedure WMLangRequest(var M: TMessage); message WM_INPUTLANGCHANGEREQUEST;
        procedure WMLangChange(var M: TMessage); message WM_INPUTLANGCHANGE;
     
        { Private declarations }
      protected
        { Protected declarations }
      public
        { Public declarations }
      published
        property OnLangChange: TLangChangeEvent read FOnLangChange write
          FOnLangChange;
     
        { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    procedure tricheditex.WMLangRequest(var M: TMessage);
    begin
      if assigned(FOnLangChange) then
        FOnLangChange(self, m.LParam);
      inherited;
    end;
     
    procedure tricheditex.WMLangChange(var M: TMessage);
    begin
      m.Result := 1;
    end;
     
    procedure Register;
    begin
      RegisterComponents('Samples', [TRichEditEx]);
    end;
     
    end.


