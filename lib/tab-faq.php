<div class="tab-pane" id="twine-tab-faq">
	<div class="row-fluid">
		<div class="span12">


			<div class="twine-widget">
				<div class="twine-widget-title">
					Help & FAQ
					<div class="twine-widget-close" data-toggle="collapse">X</div>
				</div>
				<div class="twine-widget-content">

					<H3>About the TwineSocial Wordpress Plugin</H3>
					<p class="lead">Showcase your brand's social media, beautifully presented on your Wordpress Blog.</p>
					<P ><a href="<?php echo TWINE_PUBLIC_URL?>">TwineSocial</a> provides the tools you need to grow and engage your social audience. Display any social media content on your digital properties, and drive massive social engagement.</p>
					<P>This plugin makes it <b>super easy</b> to add your social media content (including #hashtags, @accounts and locations) from any social media network to your Wordpress Blog. TwineSocial is richly interactive and engaging. Get beautiful presentation of your photos, videos, and other social media elements on your digital properties. Your customers see your brand in action, making Twine the perfect social media hub.</p>
					<P>TwineSocial is fully responsive, and supports infinite scroll.</p>

					<img class="img-responsive img-thumbnail" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/twine-wall.jpg'?>">

					<HR>

					<div class="alert alert-info">
					<P>IMPORTANT: You will FIRST need to go to <a href="http://<?php echo TWINE_PUBLIC_URL?>">TwineSocial</a>, sign up for a FREE account before you can embed it into your Wordpress site.
					</div>

					<P>If you have any questions or feedback, please visit our <a href="http://support.twinesocial.com/">support forum</a>, or <a onClick="Intercom('show');">ask a question now</a>.</p>


					<H3>Installation</H3>
					<P>First, go to <a href="http://<?php echo TWINE_PUBLIC_URL?>">TwineSocial</a> and sign up for a FREE account. Installing the plugin without a <a href="http://<?php echo TWINE_PUBLIC_URL?>">TwineSocial</a> account will not work properly.</p>

					<P>Twine can be displayed on the Wordpress sidebar or embedded in your page as a shortcode.</p>

					<HR>

					<H4>Placing your Twine feed a Wordpress Page</H4>

					<OL>
					<LI>Download the plugin and upload it into your Wordpress Plugins folder OR search "TwineSocial" in the plugin store and install it.</LI>
					<LI>Activate the plugin through the 'Plugins' menu in WordPress.</LI>
					<LI>Click on Settings -> TwineSocial Settings.</LI>
					<LI>You'll need to add your TwineSocial Account #. You can find it by logging in to http://<?php echo TWINE_CUSTOMER_URL?>, using the account you previously created. Click on settings in the top right hand corner and the Account ID will be displayed. It's a short code, like 13-ICZ5I4.</LI>
					<LI>You may have more than one TwineSocial application - one for each brand you manage. Choose one.</LI>
					<LI>Generate your shortcode, and paste it on any Wordpress Page or Post.</LI>
					</OL>

					<P><strong>That's it!</strong></p>

					<HR>

					<H4>Placing your Twine feed on the Sidebar/Widget</H4>

					<OL>
					<LI>Go to the Appearance -> Widgets, drag the "Twine Social" widget to your "Main Sidebar"</LI>
					<LI>Choose from your list of available Twine Social applications.</LI>
					</OL>


					<HR>

					<H4>Using Twine Social shortcodes</H4>

					<P>Shortcodes are the quickest way to embed TwineSocial on your WordPress site. Create a new Post and click on the Text option on the top-right hand side of the post. Paste in the generated code and press SAVE.

					<P>Many additional arguments are supported by the shortcode:</p>

					<DL>
					<DT>app="MYSITE"</DT><DD>Your Twine Social application name</DD>
					<DT>width="250px"</DT><DD>Width of your TwineSocial embedded widget</DD>
					<DT>height="500px"</DT><DD>initial height of the widget. (If you choose Infinite Scroll below, then your widget will automatically grow when the bottom of the widget is scrolled into view.)</DD>
					<DT>nav="1"</DT><DD>Enable/Disable site navigation.</DD>
					<DT>collection="252"</DT><DD>the ID of a specific collection to display, like "My Videos" or "Superbowl." Setup your collections <a href="http://<?php echo TWINE_CUSTOMER_URL?>/">here</a>.</DD>
					<DT>scroll="no"</DT><DD> Disable infinite scrolling.</DD>
					</DL>


					<P>Shortcode examples:</P>

					<div class="alert alert-info">[twinesocial app='WCD'] </div>

					<div class="alert alert-info">[twinesocial app='WCD' scroll="yes"] </div>

					<HR>

					<H3>Frequently Asked Questions</H3>

					<H4>What is Twine?</H4>

					<P><A href="http://<?php echo TWINE_PUBLIC_URL?>">Twine Social</a> provides the tools you need to grow and engage your social audience. Display any social media content on your digital properties, and drive massive social engagement.</p>

					<H3>What can I use Twine Social for?</h3>
					<P>Connect any combination of social media feeds, including hashtags, from any social media network and Twine Social will aggregate your content onto one stunning destination on your website, TV, video wall, or display.</p>
					<P>Twine Social is richly interactive and engaging. Get beautiful presentation of your photos, videos, and other social media elements on your digital properties.</p>

					<H3>How do I start using Twine Social?</H3>

					<P>First sign up for a free account at <a href="http://<?php echo TWINE_PUBLIC_URL?>">Twine Social</a>. This Wordpress plugin then allows you to embed your Twine Social feed into your WordPress site. Go to the Installation tab to easily learn how.</p>

					<H3>Help, I'm having a problem!</H3>

					<P>We apologize for any problems you may have. Feel free to Tweet us at @twinesocial, visit our <a href="http://www.facebook.com/TwineSocial">Facebook Page</a>, visit our <a href="http://support.twinesocial.com">support forum</a>, or <a onClick="Intercom('show');" >ask us a question</a>.</p>

					<HR>


					<Code>
					= 2.0 =<BR>
					* Now featuring Collection Navigation.<BR>
					* Support for infinite scroll in the sidebar Widget<BR>
					* Improved documentation.<BR>
					* Tested with Wordpress 3.8.1.
					<BR>
					= 1.4 =<BR>
					* Now with even more beautiful layouts for responsive, mobile, and table displays.<BR>
					<BR>
					= 1.3.1 =<BR>
					* Added new support multiple Twine Social applications. Choose your specific application when setting up the Wordpress Widget.<BR>
					<BR>
					= 1.3 =<BR>
					* Added new support for Collections in short codes and Widgets. Now, group and display social your content, like "Videos" or "Press Releases" in relevant sections of your Wordpress blog. Super awesome! Setup your Collections in your <a href="http://<?php echo TWINE_CUSTOMER_URL?>">Twine Social Admin Console</a>.<BR>
					<BR>
					= 1.2 =<BR>
					* Improved support for transparent IFRAMES<BR>
					<BR>
					= 1.1 =<BR>
					* Upgraded support libraries to Bootstrap 3.<BR>
					<BR>
					= 1.0 =<BR>
					* Initial Version<BR>
					== Upgrade Notice ==<BR>
					No problems should be encountered when upgrading.<BR>
					</code>


		</div>
			</div>
		</div>
	</div>
</div>

