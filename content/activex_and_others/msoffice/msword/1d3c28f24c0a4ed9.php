<h1>Как узнать версию MS Word?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ ... }
MsWord := CreateOleObject('Word.Basic');
try
  {Return Application Info. This call is the same for English and 
        French Microsoft Word.}
  Lang := MsWord.AppInfo(Integer(16));
except
  try
    {For German Microsoft Word the procedure name is translated}
    Lang := MsWord.AnwInfo(Integer(16));
  except
    try
      {For Swedish Microsoft Word the procedure name is translated}
      Lang := MsWord.PrgmInfo(Integer(16));
    except
      try
        {For Dutch Microsoft Word the procedure name is translated}
        Lang := MsWord.ToepasInfo(Integer(16));
      except
        {If this procedure does not exist there is a different translation
                          of Microsoft Word}
        ShowMessage('Microsoft Word version is not German, French, Dutch, Swedish
                                 or English.');
        Exit;
      end;
    end;
  end;
end;
ShowMessage(Lang);
{ ... }
</pre>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

