<?
/*
 ************************************************************************
 * © Sloppycode.net All rights reserved.
 *
 * This is a standard copyright header for all source code appearing
 * at sloppycode.net. This application/class/script may be redistributed,
 * as long as the above copyright remains intact. 
 * Comments to sloppycode@sloppycode.net
 ************************************************************************
*/

/*
 * Upload class - API for uploading files. See accompanying docs
 * More features and better error checking will come in the next version.
 * Please note that in most cases you should chmod a folder to 755 or 777 
 * (on unix) before uploading to there, in order for it to work.
 *
 * @author C.Small <chris@sloppycode.net>
 * @version 1.2 Changed the upload method to globalise HTTP_POST_FILES,
 * changed the copy() function to the safer (and less bug prone) 
 * move_uploaded_file() function, which works better on shared hosting.
 * @version 1.1 - Added PEAR style comments. Some requests have been made
 * to have only one save method to combine save and saveas. Its been kept
 * with 2 methods as I think this is easier to use.
 * @version 1.0 - Initial class
 * @access public
 */
class Upload
{
	/*
	 * Maximum size, in bytes, that any uploaded file can be. 
	 * If the filesize exceeds this, an error is stored in the errors property, 
	 * and the save() and saveas() methods will return false.
	 * @access public
	 * @type integer
	 */
	var $maxupload_size;
	/*
	 * Contains an error description if the save() or saveAs() methods returned false. 
	 * @access public
	 * @type string
	 */
	var $errors;
	/*
	 * Use this property to determine whether the form has been posted or not. 
	 * The save and saveAs methods detect whether the form has been posted anyhow, 
	 * this property can be used with the getFilename etc. methods, as shown in the example. 
	 * @access public
	 * @type boolean
	 */
	var $isPosted;
	/*
	 * HTTP_POST_FILES - same as PHP's global array.
	 * @access private
	 * @type array
	 */
	var $HTTP_POST_FILES;
	
	/*
	 * Constructor for the class. This should be called with $HTTP_POST_FILES, 
	 * passed by reference (using & prefixed to it), for the class to work correctly. 
	 * See the example for usage.
	 * @access public
	 * @return void
	 */
	function Upload()
	{
		global $HTTP_POST_FILES;
		
		$this->HTTP_POST_FILES = $HTTP_POST_FILES;
		
		if ( empty($HTTP_POST_FILES) )
		{
			$this->isPosted = false;
		} else {
			$this->isPosted = true;
		}
	}
	
	/*
 	 * Saves the form field specified in $field, to the directory specified by $directory, 
	 * using the filename of the file uploaded. If $overwrite is set to true, this will overwrite
	 * the file if it already exists in the directory. $mode is the unix mode to save as, default is 777.
	 * Returns true if the upload was succesful, or false if not - the error can then be retrieved with the
	 * errors property.
	 * @access public
	 * @param string $directory directory to save the file in
	 * @param string $field form field element name (file input box)
	 * @param boolean $overwrite whether to overwrite the file if it already exists
	 * @param integer $mode The unix mode to change the files permissions to (see www.slopycode.net/nix) default is 0777
	 * @return boolean indicates whether the upload was successful or not
	 */
	function save($directory, $field, $overwrite,$mode=0777)
	{
		$this->isPosted = true;
		if ($this->HTTP_POST_FILES[$field]['size'] < $this->maxupload_size && $this->HTTP_POST_FILES[$field]['size'] >0)
		{
			$noerrors = true;
			$this->isPosted = true;
			// Get names
			$tempName  = $this->HTTP_POST_FILES[$field]['tmp_name'];
			$file      = $this->HTTP_POST_FILES[$field]['name'];
			$all       = $directory.$file;

			// Copy to directory
			if (file_exists($all))
			{
				if ($overwrite)
				{
					@unlink($all)         || $noerrors=false; $this->errors  = "Upload class save error: unable to overwrite ".$all."<BR>";
					@move_uploaded_file($tempName,$all) || $noerrors=false; $this->errors .= "Upload class save error: unable to copy to ".$all."<BR>";
					@chmod($all,$mode)    || $ernoerrorsrors=false; $this->errors .= "Upload class save error: unable to change permissions for: ".$all."<BR>";
				}
			} else{
				@move_uploaded_file($tempName,$all)   || $noerrors=false;$this->errors  = "Upload class save error: unable to copy to ".$all."<BR>";
				@chmod($all,$mode)      || $noerrors=false;$this->errors .= "Upload class save error: unable to change permissions for: ".$all."<BR>";
			}
			return $noerrors;
		} elseif ($this->HTTP_POST_FILES[$field]['size'] > $this->maxupload_size) {
			$this->errors = "File size exceeds maximum file size of ".$this->maxupload_size." bytes";
			return false;
		} elseif ($this->HTTP_POST_FILES[$field]['size'] == 0) {
			$this->errors = "File size is 0 bytes";
			return false;
		}
	}
	
	/*
	 * Saves the form field specified in $field, to the directory specified by $directory,
	 * with the filename specified by $filename. If $overwrite is set to true, this will 
	 * overwrite the file if it already exists in the directory. $mode is the unix mode to save as,
	 * default is 777. Returns true if the upload was succesful, or false if not - the error can then
	 * be retrieved with the errors property. 
	 * @access public
	 * @param string $filename name of the file to save as
	 * @param string $directory directory to save the fiel to
	 * @param string $field form field element name (file input box)
	 * @param boolean $overwrite whether to overwrite the file if it already exists
	 * @param integer $mode The unix mode to change the files permissions to (see www.slopycode.net/nix) default is 0777
	 * @return boolean indicates whether the upload was successful or not.
	 */
	function saveAs($filename, $directory, $field, $overwrite,$mode=0777)
	{
		$this->isPosted = true;
		if ($this->HTTP_POST_FILES[$field]['size'] < $this->maxupload_size && $this->HTTP_POST_FILES[$field]['size'] >0)
		{
			$noerrors = true;

			// Get names
			$tempName  = $this->HTTP_POST_FILES[$field]['tmp_name'];
			$all       = $directory.$filename;
			
			// Copy to directory
			if (file_exists($all))
			{
				if ($overwrite)
				{
					@unlink($all)         || $noerrors=false; $this->errors  = "Upload class saveas error: unable to overwrite ".$all."<BR>";
					@move_uploaded_file($tempName,$all) || $noerrors=false; $this->errors .= "Upload class saveas error: unable to copy to ".$all."<BR>";
					@chmod($all,$mode)    || $noerrors=false; $this->errors .= "Upload class saveas error: unable to copy to".$all."<BR>";
				}
			} else{
				@move_uploaded_file($tempName,$all)   || $noerrors=false; $this->errors  = "Upload class saveas error: unable to copy to ".$all."<BR>";
				@chmod($all,$mode)      || $noerrors=false; $this->errors .= "Upload class saveas error: unable to change permissions for: ".$all."<BR>";
			}
			return $noerrors;
		} elseif ($this->HTTP_POST_FILES[$field]['size'] > $this->maxupload_size) {
			$this->errors = "File size exceeds maximum file size of ".$this->maxuploadsize." bytes";
			return false;
		} elseif ($this->HTTP_POST_FILES[$field]['size'] == 0) {
			$this->errors = "File size is 0 bytes";
			return false;
		}
	}
	
	/*
	 * Returns a string with the filename for the html form field specified by $field. 
	 * @access public
	 * @param string $field form field element name
	 * @return string the filename from the field given.
	 */
	function getFilename($field)
	{
		return $this->HTTP_POST_FILES[$field]['name'];
	}
	/*
	 * Returns a string with the mime type (e.g. image/gif) for the html form field specified by $field. 
	 * @access public
	 * @param string $field form field element name
	 * @return string mime type of the field
	 */
	function getFileMimeType($field)
	{
		return $this->HTTP_POST_FILES[$field]['type'];
	}
	/*
	 * Returns a string with the filesize of a html form field, specified by $field. 
	 * @access public
	 * @param string $field form field element name
	 * @return string filesize in bytes, of the file.
	 */
	function getFileSize($field)
	{
		return $this->HTTP_POST_FILES[$field]['size'];
	}

}

?>