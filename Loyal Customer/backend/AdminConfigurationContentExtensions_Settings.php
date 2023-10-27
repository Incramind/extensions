<div id="config_tabs_ConfigurationViewsettings_content" class="tabs_content" style="display:none">
	<div class="entry-edit">
		[:FormContainer,AdminLoyalCustomerSettingForm,,Configuration/Save,post,enctype="multipart/form-data",]
		<input type="hidden" name="id" value="[Configuration.Id]"/>
		<input type="hidden" name="store_view_id" value="[StoreView.Id]"/>
		<div class="entry-edit-head">
			<h4>[_Loyal customer configuration settings]</h4>
			<div class="form-buttons"></div>
		</div>
		<div class="fieldset " id="page_base_fieldset">
			<div class="hor-scroll">
				<table cellspacing="0" class="form-list">
					<tbody>
						[:FormOptionsYesNo,
							loyalcustomerenabled,
							loyalcustomerenabled,
							[_Enable Loyal Customer],
							false,
							,
							[Configuration.LoyalCustomerEnabled],
							,Configuration.LoyalCustomerEnabled
						]

						[:FormCustomerGroupSelector,
							loyaldestinationgroup,
							loyaldestinationgroup,
							[_Destination Group],
							false,
							,
							[Configuration.LoyalDestinationGroup],
							false,
							false,
							Configuration.LoyalDestinationGroup
						]
/*
						[:FormCustomerGroupSelector,
							loyalorigingroup,
							loyalorigingroup,
							[_Origin Group],
							false,
							,
							[Configuration.LoyalOriginGroup],
							false,
							false,
							Configuration.LoyalOriginGroup
						]

							[:FormInteger,
                            loyalminnrorders,
                            loyalminnrorders,
                            [_Loyal Min Nr of Orders],
                            false,
                            loyalminnrorders,
                            [Configuration.Loyalminnrorders],
                            false,
                            Configuration.Loyalminnrorders
                        ]

                        	[:FormInteger,
                            loyalminnritems,
                            loyalminnritems,
                            [_Minimum Nr of Items],
                            false,
                            loyalminnritems,
                            [Configuration.LoyalMinNrItems],
                            false,
                            Configuration.LoyalMinNrItems
                        ]


                       [:FormInputNumber,
	                        loyalminamount,
	                        loyalminamount,
	                        [_Minimum Amount],
	                        true,,
	                        [Configuration.LoyalMinAmount],
	                        false,
	                        Configuration.LoyalMinAmount
		                ]

		                [:FormInteger,
                            loyaldays,
                            loyaldays,
                            [_Loyal Days],
                            false,
                            loyaldays,
                            [Configuration.LoyalDays],
                            false,
                            Configuration.LoyalDays
                        ]
                        [:FormOptionsYesNo,
							loyalcanfallback,
							loyalcanfallback,
							[_Can Fall Back],
							false,
							,
							[Configuration.LoyalCanFallBack],
							,Configuration.LoyalCanFallBack
						]
						 [:FormInteger,
                            loyalfallbackdays,
                            loyalfallbackdays,
                            [_Loyal Fall Back Days],
                            false,
                            loyaldays,
                            [Configuration.LoyalFallBackDays],
                            false,
                            Configuration.LoyalFallBackDays
                        ]
                        [:FormTypeEmail,
							loyalemail,
							loyalemail,
							[_Email],
							email,
							true,
							false,
							[Configuration.LoyalEmail],
							Configuration.LoyalEmail
						]
						[:FormTypeEmail,
							loyalfallbackemail,
							loyalfallbackemail,
							[_Fall Back Email],
							fallbackemail,
							true,
							false,
							[Configuration.LoyalFallBackEmail],
							Configuration.LoyalFallBackEmail
						]
						[:FormInteger,
                            loyalwarningdays,
                            loyalwarningdays,
                            [_Loyal Warning Days],
                            false,
                            warningdays,
                            [Configuration.LoyalWarningDays],
                            false,
                            Configuration.LoyalWarningDays
                        ]
                        [:FormTypeEmail,
							loyalwarningemail,
							loyalwarningemail,
							[_Warning Email],
							warningemail,
							true,
							false,
							[Configuration.LoyalWarningEmail],
							Configuration.LoyalWarningEmail
						]
						*/
					</tbody>
				</table>
			</div>
		</div>
		</form>
	</div>
</div>