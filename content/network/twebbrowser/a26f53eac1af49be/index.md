---
Title: Как получить URL?
Author: P.O.D.
Date: 01.01.2007
---


Как получить URL?
=================

::: {.date}
01.01.2007
:::

TWebBrowser.После нажатия кнопки на web форме формируется ссылка на
какуюто страницу с параметрами,а с этой страницы уже происходит
перенаправление на результирующую страницу. Хотелось бы увидеть ссылку
на страницу вместе с параметрами.

    function GetPostParam(const PostData: OleVariant): string;
    var
      V: Variant;
      P: PChar;
      lb, hb, i: Integer;
    begin
    V:=Variant(TVarData(PostData).VPointer^);
    if VarIsArray(V) then begin
     P:=VarArrayLock(V);
      try
       lb := VarArrayLowBound(V, 1);
       hb := VarArrayHighBound(V, 1);
       SetString(Result, P, hb - lb + 1);
       for i := 1 to Length(Result) do if Result[i] = #0 then begin
       SetLength(Result, i - 1); Break; end; Exit;
      finally  VarArrayUnlock(V);   end;
     end;
    Result:= '';
    end;

Автор: P.O.D.

Взято из <https://forum.sources.ru>
