---
Title: Как изменить уровень громкости микрофона?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как изменить уровень громкости микрофона?
=========================================

    uses 
      MMSystem; 
     
    // Set the volume for the microphone 
     
    function SetMicrophoneVolume(bValue: Word): Boolean; 
    var                          {0..65535} 
      hMix: HMIXER; 
      mxlc: MIXERLINECONTROLS; 
      mxcd: TMIXERCONTROLDETAILS; 
      vol: TMIXERCONTROLDETAILS_UNSIGNED; 
      mxc: MIXERCONTROL; 
      mxl: TMixerLine; 
      intRet: Integer; 
      nMixerDevs: Integer; 
    begin 
      // Check if Mixer is available 
      nMixerDevs := mixerGetNumDevs(); 
      if (nMixerDevs < 1) then 
      begin 
        Exit; 
      end; 
     
      // open the mixer 
      intRet := mixerOpen(@hMix, 0, 0, 0, 0); 
      if intRet = MMSYSERR_NOERROR then 
      begin 
        mxl.dwComponentType := MIXERLINE_COMPONENTTYPE_SRC_MICROPHONE; 
        mxl.cbStruct := SizeOf(mxl); 
     
        // get line info 
        intRet := mixerGetLineInfo(hMix, @mxl, MIXER_GETLINEINFOF_COMPONENTTYPE); 
     
        if intRet = MMSYSERR_NOERROR then 
        begin 
          ZeroMemory(@mxlc, SizeOf(mxlc)); 
          mxlc.cbStruct := SizeOf(mxlc); 
          mxlc.dwLineID := mxl.dwLineID; 
          mxlc.dwControlType := MIXERCONTROL_CONTROLTYPE_VOLUME; 
          mxlc.cControls := 1; 
          mxlc.cbmxctrl := SizeOf(mxc); 
     
          mxlc.pamxctrl := @mxc; 
          intRet := mixerGetLineControls(hMix, @mxlc, MIXER_GETLINECONTROLSF_ONEBYTYPE); 
     
          if intRet = MMSYSERR_NOERROR then 
          begin 
          { 
           // Microphone Name 
              Label1.Caption := mxlc.pamxctrl.szName; 
     
            // Min/Max Volume 
            Label2.Caption := IntToStr(mxc.Bounds.dwMinimum) + '->' + IntToStr(mxc.Bounds.dwMaximum); 
          } 
            ZeroMemory(@mxcd, SizeOf(mxcd)); 
            mxcd.dwControlID := mxc.dwControlID; 
            mxcd.cbStruct := SizeOf(mxcd); 
            mxcd.cMultipleItems := 0; 
            mxcd.cbDetails := SizeOf(Vol); 
            mxcd.paDetails := @vol; 
            mxcd.cChannels := 1; 
     
            // vol.dwValue := mxlc.pamxctrl.Bounds.lMinimum; Set min. Volume / Minimum setzen 
            // vol.dwValue := mxlc.pamxctrl.Bounds.lMaximum; Set max. Volume / Maximum setzen 
            vol.dwValue := bValue; 
     
            intRet := mixerSetControlDetails(hMix, @mxcd, 
              MIXER_SETCONTROLDETAILSF_VALUE); 
            if intRet <> MMSYSERR_NOERROR then 
              ShowMessage('SetControlDetails Error'); 
          end 
          else 
            ShowMessage('GetLineInfo Error'); 
        end; 
        intRet := mixerClose(hMix); 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SetMicrophoneVolume(30000); 
    end; 
     
    {********************************************************} 
     
     
    // Enable/disable "Mute Microphone Volume" 
     
    function SetMicrophoneVolumeMute(bMute: Boolean): Boolean; 
    var 
      hMix: HMIXER; 
      mxlc: MIXERLINECONTROLS; 
      mxcd: TMIXERCONTROLDETAILS; 
      vol: TMIXERCONTROLDETAILS_UNSIGNED; 
      mxc: MIXERCONTROL; 
      mxl: TMixerLine; 
      intRet: Integer; 
      nMixerDevs: Integer; 
      mcdMute: MIXERCONTROLDETAILS_BOOLEAN; 
    begin 
      // Check if Mixer is available 
      // Uberprufen, ob ein Mixer vorhanden ist 
      nMixerDevs := mixerGetNumDevs(); 
      if (nMixerDevs < 1) then 
      begin 
        Exit; 
      end; 
     
      // open the mixer 
      intRet := mixerOpen(@hMix, 0, 0, 0, 0); 
      if intRet = MMSYSERR_NOERROR then 
      begin 
        mxl.dwComponentType := MIXERLINE_COMPONENTTYPE_SRC_MICROPHONE; 
        mxl.cbStruct        := SizeOf(mxl); 
     
        // mixerline info 
        intRet := mixerGetLineInfo(hMix, @mxl, MIXER_GETLINEINFOF_COMPONENTTYPE); 
     
        if intRet = MMSYSERR_NOERROR then 
        begin 
          ZeroMemory(@mxlc, SizeOf(mxlc)); 
          mxlc.cbStruct := SizeOf(mxlc); 
          mxlc.dwLineID := mxl.dwLineID; 
          mxlc.dwControlType := MIXERCONTROL_CONTROLTYPE_MUTE; 
          mxlc.cControls := 1; 
          mxlc.cbmxctrl := SizeOf(mxc); 
          mxlc.pamxctrl := @mxc; 
     
          // Get the mute control 
          intRet := mixerGetLineControls(hMix, @mxlc, MIXER_GETLINECONTROLSF_ONEBYTYPE); 
     
          if intRet = MMSYSERR_NOERROR then 
          begin 
            ZeroMemory(@mxcd, SizeOf(mxcd)); 
            mxcd.cbStruct := SizeOf(TMIXERCONTROLDETAILS); 
            mxcd.dwControlID := mxc.dwControlID; 
            mxcd.cChannels := 1; 
            mxcd.cbDetails := SizeOf(MIXERCONTROLDETAILS_BOOLEAN); 
            mxcd.paDetails := @mcdMute; 
     
            mcdMute.fValue := Ord(bMute); 
     
            // set, unset mute 
            intRet := mixerSetControlDetails(hMix, @mxcd, 
              MIXER_SETCONTROLDETAILSF_VALUE); 
              { 
              mixerGetControlDetails(hMix, @mxcd, 
                                     MIXER_GETCONTROLDETAILSF_VALUE); 
              Result := Boolean(mcdMute.fValue); 
              } 
            Result := intRet = MMSYSERR_NOERROR; 
     
            if intRet <> MMSYSERR_NOERROR then 
              ShowMessage('SetControlDetails Error'); 
          end 
          else 
            ShowMessage('GetLineInfo Error'); 
        end; 
     
        intRet := mixerClose(hMix); 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SetMicrophoneVolumeMute(False); 
    end; 

    {********************************************************} 
     
    // Enable/disable "Mute" for several mixer line sources. 
     
    uses 
      MMSystem; 
     
    type 
     TMixerLineSourceType = (lsDigital, lsLine, lsMicrophone, lsCompactDisk, lsTelephone, 
                             lsWaveOut, lsAuxiliary, lsAnalog, lsLast); 
     
    function SetMixerLineSourceMute(AMixerLineSourceType: TMixerLineSourceType; bMute: Boolean): Boolean; 
    var 
      hMix: HMIXER; 
      mxlc: MIXERLINECONTROLS; 
      mxcd: TMIXERCONTROLDETAILS; 
      vol: TMIXERCONTROLDETAILS_UNSIGNED; 
      mxc: MIXERCONTROL; 
      mxl: TMixerLine; 
      intRet: Integer; 
      nMixerDevs: Integer; 
      mcdMute: MIXERCONTROLDETAILS_BOOLEAN; 
    begin 
      Result := False; 
      // Check if Mixer is available 
      nMixerDevs := mixerGetNumDevs(); 
      if (nMixerDevs < 1) then 
      begin 
        Exit; 
      end; 
     
      // open the mixer 
      intRet := mixerOpen(@hMix, 0, 0, 0, 0); 
      if intRet = MMSYSERR_NOERROR then 
      begin 
        ZeroMemory(@mxl, SizeOf(mxl)); 
        case AMixerLineSourceType of 
          lsDigital: mxl.dwComponentType :=MIXERLINE_COMPONENTTYPE_SRC_DIGITAL; 
          lsLine: mxl.dwComponentType := MIXERLINE_COMPONENTTYPE_SRC_LINE; 
          lsMicrophone: mxl.dwComponentType :=MIXERLINE_COMPONENTTYPE_SRC_MICROPHONE; 
          lsCompactDisk: mxl.dwComponentType :=MIXERLINE_COMPONENTTYPE_SRC_COMPACTDISC; 
          lsTelephone: mxl.dwComponentType :=MIXERLINE_COMPONENTTYPE_SRC_TELEPHONE; 
          lsWaveOut: mxl.dwComponentType :=MIXERLINE_COMPONENTTYPE_SRC_WAVEOUT; 
          lsAuxiliary: mxl.dwComponentType :=MIXERLINE_COMPONENTTYPE_SRC_AUXILIARY; 
          lsAnalog : mxl.dwComponentType :=MIXERLINE_COMPONENTTYPE_SRC_ANALOG; 
          lsLast: mxl.dwComponentType :=MIXERLINE_COMPONENTTYPE_SRC_LAST; 
        end; 
     
        // mixerline info 
        mxl.cbStruct := SizeOf(mxl); 
        intRet := mixerGetLineInfo(hMix, @mxl, MIXER_GETLINEINFOF_COMPONENTTYPE); 
     
        if intRet = MMSYSERR_NOERROR then 
        begin 
          ZeroMemory(@mxlc, SizeOf(mxlc)); 
          mxlc.cbStruct := SizeOf(mxlc); 
          mxlc.dwLineID := mxl.dwLineID; 
          mxlc.dwControlType := MIXERCONTROL_CONTROLTYPE_MUTE; 
          mxlc.cControls := 1; 
          mxlc.cbmxctrl := SizeOf(mxc); 
          mxlc.pamxctrl := @mxc; 
     
          // Get the mute control 
          intRet := mixerGetLineControls(hMix, @mxlc, MIXER_GETLINECONTROLSF_ONEBYTYPE); 
     
          if intRet = MMSYSERR_NOERROR then 
          begin 
            ZeroMemory(@mxcd, SizeOf(mxcd)); 
            mxcd.cbStruct := SizeOf(TMIXERCONTROLDETAILS); 
            mxcd.dwControlID := mxc.dwControlID; 
            mxcd.cChannels := 1; 
            mxcd.cbDetails := SizeOf(MIXERCONTROLDETAILS_BOOLEAN); 
            mxcd.paDetails := @mcdMute; 
     
            mcdMute.fValue := Ord(bMute); 
     
            // set, unset mute 
            intRet := mixerSetControlDetails(hMix, @mxcd, MIXER_SETCONTROLDETAILSF_VALUE); 
            { 
            mixerGetControlDetails(hMix, @mxcd, IXER_GETCONTROLDETAILSF_VALUE); 
            Result := Boolean(mcdMute.fValue); 
            } 
            Result := intRet = MMSYSERR_NOERROR; 
     
            if intRet <> MMSYSERR_NOERROR then 
              ShowMessage('SetControlDetails Error'); 
          end 
          else 
            ShowMessage('GetLineInfo Error'); 
        end; 
        intRet := mixerClose(hMix); 
      end; 
    end; 
     
    // Example Call; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SetMixerLineSourceMute(lsLine, True); 
    end; 

