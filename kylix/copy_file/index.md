---
Title: CopyFile для Linux
Author: Vit
Date: 01.01.2007
---


CopyFile для Linux
==================

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
