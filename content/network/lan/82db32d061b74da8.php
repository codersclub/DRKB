<h1>Сканирование доменов локальной сети</h1>
<div class="date">01.01.2007</div>


<p>Переменная List заполняется списком доменов. Функция возвращает код ошибки обращения к сети. </p>
<pre>
Function FillNetLevel(xxx: PNetResource; list: TStrings) : Word;
Type
    PNRArr = ^TNRArr;
    TNRArr = array[0..59] of TNetResource;
Var
   x: PNRArr;
   tnr: TNetResource;
   I : integer;
   EntrReq,
   SizeReq,
   twx: Integer;
   WSName: string;
begin
     Result := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_ANY,
                                RESOURCEUSAGE_CONTAINER, xxx, twx);
     If Result = ERROR_NO_NETWORK Then Exit;
     if Result = NO_ERROR then
     begin
            New(x);
            EntrReq := 1;
            SizeReq := SizeOf(TNetResource)*59;
            while (twx &lt;&gt; 0) and 
                  (WNetEnumResource(twx, EntrReq, x, SizeReq) &lt;&gt; ERROR_NO_MORE_ITEMS) do
            begin
                  For i := 0 To EntrReq - 1 do
                  begin
                   Move(x^[i], tnr, SizeOf(tnr));
                   case tnr.dwDisplayType of
                    RESOURCEDISPLAYTYPE_DOMAIN:
                    begin
                       if tnr.lpRemoteName &lt;&gt; '' then
                           WSName:= tnr.lpRemoteName
                           else WSName:= tnr.lpComment;
                       list.Add(WSName);
                    end;
                    else FillNetLevel(@tnr, list);
                   end;
                  end;
            end;
            Dispose(x);
            WNetCloseEnum(twx);
     end;
end;
</pre>


<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>
