<?php
/*
** Zabbix
** Copyright (C) 2001-2019 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


/**
 * Actions operation new condition popup.
 */
class CControllerPopupConditionOperationsEdit extends CControllerPopupConditionCommon {

	protected function getCheckInputs() {
		return [
			'type' =>			'required|in '.ZBX_POPUP_CONDITION_TYPE_ACTION_OPERATION,
			'source' =>			'required|in '.implode(',', [EVENT_SOURCE_TRIGGERS, EVENT_SOURCE_DISCOVERY, EVENT_SOURCE_AUTO_REGISTRATION, EVENT_SOURCE_INTERNAL]),
			'validate' =>		'in 1',
			'condition_type' =>	'not_empty|in '.implode(',', [CONDITION_TYPE_EVENT_ACKNOWLEDGED]),
			'operator' =>		'not_empty|in '.implode(',', [CONDITION_OPERATOR_EQUAL]),
			'value' =>			'not_empty|in '.implode(',', [EVENT_NOT_ACKNOWLEDGED, EVENT_ACKNOWLEDGED])
		];
	}

	protected function getConditionLastType() {
		return CONDITION_TYPE_EVENT_ACKNOWLEDGED;
	}

	protected function validateFieldsManually() {
		return true;
	}

	protected function getManuallyValidatedFields() {
		return [
			'form' => [
				'name' => 'action.edit',
				'param' => 'add_opcondition',
				'input_name' => 'new_opcondition'
			],
			'inputs' => [
				'conditiontype' => $this->getInput('condition_type'),
				'operator' => $this->getInput('operator'),
				'value' => $this->getInput('value')
			]
		];
	}

	protected function getControllerResponseData() {
		return [
			'title' => _('New condition'),
			'command' => '',
			'message' => '',
			'errors' => null,
			'action' => $this->getAction(),
			'type' => $this->getInput('type'),
			'last_type' => $this->getConditionLastType(),
			'source' => $this->getInput('source'),
			'allowed_conditions' => get_opconditions_by_eventsource($this->getInput('source')),
			'user' => [
				'debug_mode' => $this->getDebugMode()
			]
		];
	}
}
