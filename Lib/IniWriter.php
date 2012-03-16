<?php

class IniWriter {

	public static function write($file, $data = array()) {
		return IniWriter::_writeIniFile($data, $file, true);
	}

	protected static function _writeIniFile($assoc_arr, $path, $hasSections = FALSE) {
		$content = "";
		if ($hasSections) {
			foreach ($assoc_arr as $key => $elem) {
				$content .= "[" . $key . "]\n";
				foreach ($elem as $key2 => $elem2) {
					if (is_array($elem2)) {
						for ($i = 0; $i < count($elem2); $i++) {
							$content .= $key2 . "[] = \"" . $elem2[$i] . "\"\n";
						}
					} else if ($elem2 == "") {
						$content .= $key2 . " = \n";
					} else {
						$content .= $key2 . " = \"" . $elem2 . "\"\n";
					}
				}
				$content .= "\n";
			}
		} else {
			foreach ($assoc_arr as $key => $elem) {
				if (is_array($elem)) {
					for ($i = 0; $i < count($elem); $i++) {
						$content .= $key . "[] = \"" . $elem[$i] . "\"\n";
					}
				} else if ($elem == "") {
					$content .= $key . " = \n";
				} else {
					$content .= $key . " = \"" . $elem . "\"\n";
				}
			}
		}

		if (!$handle = fopen($path, 'w')) {
			return false;
		}
		if (!fwrite($handle, $content)) {
			return false;
		}
		fclose($handle);
		return true;
	}

}