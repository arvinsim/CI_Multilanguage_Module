<?php

	if (!defined('BASEPATH'))
	{
		exit('No direct script access allowed');
	}

	class CI_multilanguage_upd
	{
		public $version = '0.4';
		private $module_name = "CI_multilanguage";

		public function __construct()
		{
		}

		/**
		 * Install the module
		 *
		 * @return boolean TRUE
		 */
		public function install()
		{
			$data = array(
				'module_name'		 => $this->module_name,
				'module_version'	 => $this->version,
				'has_cp_backend'	 => 'n',
				'has_publish_fields' => 'n'
			);

			ee()->db->insert('modules', $data);

			// Add action that switches language
			$data = array(
				'class'	 => 'CI_multilanguage',
				'method' => 'action_switch_language'
			);

			ee()->db->insert('actions', $data);

			return TRUE;
		}

		/**
		 * Uninstall the module
		 *
		 * @return boolean TRUE
		 */
		public function uninstall()
		{
			ee()->db->select('module_id');
			$query = ee()->db->get_where('modules', array('module_name' => $this->module_name)
			);

			ee()->db->where('module_id', $query->row('module_id'));
			ee()->db->delete('module_member_groups');

			ee()->db->where('module_name', $this->module_name);
			ee()->db->delete('modules');

			ee()->db->where('class', $this->module_name);
			ee()->db->delete('actions');

			ee()->db->where('class', $this->module_name . '_mcp');
			ee()->db->delete('actions');

			return TRUE;
		}

		/**
		 * Update the module
		 *
		 * @return boolean
		 */
		public function update($current = '')
		{
			if ($current == $this->version)
			{
				// No updates
				return FALSE;
			}

			return TRUE;
		}
	}

	/* End of file upd.ci_multilanguage.php */
	/* Location: /system/expressionengine/third_party/ci_multilanguage/upd.ci_multilanguage.php */ 