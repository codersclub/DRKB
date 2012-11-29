Как сделать TWebBrowser плоским вместо 3D?
==========================================

::: {.date}
01.01.2007
:::

Взято из FAQ:<https://blackman.km.ru/myfaq/cont4.phtml>

Перевод материала с сайта members.home.com/hfournier/webbrowser.htm

Следующий пример устанавливает borderStyle:

    procedure TForm1.WBDocumentComplete(Sender: TObject;
      const pDisp: IDispatch; var URL: OleVariant);
    var
      Doc : IHTMLDocument2;
      Element : IHTMLElement;
    begin
    Doc := IHTMLDocument2(TWebBrowser(Sender).Document);
    if Doc = nil then Exit;
    Element := Doc.body;
    if Element = nil then Exit;
    case Make_Flat of
    TRUE : Element.style.borderStyle := 'none';
    FALSE : Element.style.borderStyle := '';
    end;
    end;

Автор: Donovan J. Edye
