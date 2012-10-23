<h1>TRichEdit сам меняет язык при перемещении</h1>
<div class="date">01.01.2007</div>

Самое главное, что мне не нравится в Richedit - это то, что он сам меняет язык при перемещении по тексту, не смотря, что вы включили нужный язык, при переходе на участок текста, набраный другим языком.</p>
<p>этот баг я обхожу так.</p>
<p>я создаю потомка Richedit:</p>
<p>меню Component\New Component</p>
<p>указываю предком TRichedit</p>
<p>Переписаю обработку события WM_INPUTLANGCHANGE, при этом я не вызываю обработчик предка, т.е. Richedit-а</p>
<p>Заодно обрабатываю событие WM_INPUTLANGCHANGEREQUEST, которое сообщает, что пользователь изменил язык. Тут надо вызвать обработчик предка, а то не будет переключаться язык.</p>
<p>Вот что из этого получилось. Имеем исправленный компонент VCL с дополнительным событием.</p>
<pre>unit RichEditEx;
 
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
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

