<h1>Текст между двумя определенными строками</h1>
<div class="date">01.01.2007</div>


<pre>
Procedure IsolateText( Const S: String; Tag1, Tag2: String; list:TStrings );
  Var
    pScan, pEnd, pTag1, pTag2: PChar;
    foundText: String;
    searchtext: String;
  Begin
    { Set up pointers we need for the search. HTML is not case sensitive, so
      we need to perform the search on a uppercased copy of S.}
    searchtext := Uppercase(S);
    Tag1:= Uppercase( Tag1 );
    Tag2:= Uppercase( Tag2 );
    pTag1:= PChar(Tag1);
    pTag2:= PChar(Tag2);
    pScan:= PChar(searchtext);
    Repeat
      { Search for next occurence of Tag1. }
      pScan:= StrPos( pScan, pTag1 );
      If pScan &lt;&gt; Nil Then Begin
        { Found one, hop over it, then search from that position
          forward for the next occurence of Tag2. }
        Inc(pScan, Length( Tag1 ));
        pEnd := StrPos( pScan, pTag2 );
        If pEnd &lt;&gt; Nil Then Begin
          { Found start and end tag, isolate text between,
            add it to the list. We need to get the text from
            the original S, however, since we want the un-uppercased
            version! So we calculate the address pScan would hold if
            the search had been performed on S instead of searchtext. }
          SetString( foundText, 
                     Pchar(S) + (pScan- PChar(searchtext) ),
                     pEnd - pScan );
          list.Add( foundText );
 
          { Continue next search after the found end tag. }
          pScan := pEnd + Length(tag2);
        End { If }
        Else { Error, no end tag found for start tag, abort. }
          pScan := Nil;
      End; { If }
    Until pScan = Nil;
  End;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
