<h1>CopyFile для Linux</h1>
<div class="date">01.01.2007</div>


<pre>
function CopyFile(Org, Dest:string):boolean;
  var Source, Target:TFileStream;
begin
  Result:=false;
  try
    try
      Source:=TFileStream.Create(Org, fmShareDenyNone or fmOpenRead);
      try
        Target:=TFileStream.Create(Dest, fmOpenWrite or fmCreate);
        Target.CopyFrom(Source,Source.Size);
        Result:=true;
      finally
        Target.Free;
      end;
    finally
      Source.Free;
    end;
  except
  end;
end;
</pre>

<p class="author">Автор: Vit</p>
