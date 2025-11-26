jQuery(document).ready(function ($) {

	$('#sai_engine_generate_content_button').on('click', function () {
		// Get the prompt value 

		var prompt = $('#sai_engine_prompt').val();

		// Simple validation
		if (prompt.trim() === '') {
			alert('Please enter a topic.');
			return;
		}

		// Disable the button to prevent multiple clicks
		$(this).prop('disabled', true).text('Generating...');

		// Make an AJAX request to generate content
		$.ajax({
			url: sai_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'sai_engine_generate',
				prompt: prompt,
				security: sai_ajax.nonce
			},
			success: function (response) {

				if (!response || !response.success) {
					console.warn('AJAX returned error:', response);
					alert('Error: ' + (response && response.data ? response.data : 'Unknown'));
					return;
				}

				// Possible shapes we've seen:
				// 1) response.data.content is an object: { title, sections, article, excerpt }
				// 2) response.data.content is a JSON string: '{"title":"...","sections":"..."}'
				// 3) response.data is already the object: { title, sections, ... }
				// 4) response.data.content is a single string (fallback)

				var payload = null;

				// Try shape 1 & 2
				if (response.data && response.data.content !== undefined) {
					payload = response.data.content;
					// If payload is a string that looks like JSON, try to parse it
					if (typeof payload === 'string') {
						payload = payload.trim();
						try {
							if (payload && (payload.charAt(0) === '{' || payload.charAt(0) === '[')) {
								payload = JSON.parse(payload);
								console.log('Parsed JSON payload from response.data.content');
							} else {
								// it's a plain string (single generated text)
								payload = { article: payload };
							}
						} catch (e) {
							console.warn('Failed to parse response.data.content as JSON:', e, payload);
							payload = { article: payload };
						}
					}
				} else if (response.data && (response.data.title || response.data.article || response.data.sections)) {
					// shape 3
					payload = response.data;
				} else {
					// unknown shape: put raw text into article field
					payload = { article: JSON.stringify(response.data) };
				}

				// Safe assignment helper: only set if value is present
				function safeSet(selector, value) {
					var $el = $(selector);
					if ($el.length === 0) {
						console.warn('Element not found for selector:', selector);
						return;
					}
					// Prefer .val for inputs/textarea; fallback to text()
					try {
						$el.val(value == null ? '' : value);
					} catch (err) {
						console.warn('Failed to set value via .val(), trying .text():', err);
						$el.text(value == null ? '' : value);
					}
				}
				console.log('Payload to set:', response.data);

				// Now set fields if present
				safeSet('#sai_engine_title', payload.title);
				safeSet('#sai_engine_sections', payload.sections);
				safeSet('#sai_engine_content', payload.article || payload.content || payload.text);
				safeSet('#sai_engine_excerpt', payload.excerpt);

				alert('Content generated successfully!');
			},
			error: function () {
				alert('An unexpected error occurred.');
			},
			complete: function () {
				// Re-enable the button
				$('#sai_engine_generate_content_button').prop('disabled', false).text('Generate Content');
			}
		});
	});
});

jQuery(document).ready(function ($) {
	$('#sai_engine_post_type').on('change', function () {
		var value = $(this).val();
		var key = 'post_type';
		currentSettings( key, value);
	});

	$('#sai_engine_language').on('change', function () {
		var value = $(this).val();
		var key = 'language';
		currentSettings( key, value);
	});

	$('#sai_engine_env').on('change', function () {
		var value = $(this).val();
		var key = 'environment';
		currentSettings( key, value);
	});

	$('#sai_engine_model').on('change', function () {
		var value = $(this).val();
		var key = 'model';
		currentSettings( key, value);
	});

	$('#sai_engine_temperature').on('change', function () {
		var value = $(this).val();
		var key = 'temperature';
		currentSettings( key, value);
	});

	$('#sai_engine_max_length').on('change', function () {
		var value = $(this).val();
		var key = 'max_length';
		currentSettings( key, value);
	});

	function currentSettings( key, value) {

		$.ajax({
			url: sai_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'sai_engine_generate_content_options',
				key: key,
				value: value,
				security: sai_ajax.nonce
			},
			success: function (response) {

				console.log(response);

				// if (!response || !response.success) {
				// 	console.warn('AJAX returned error:', response);
				// 	alert('Error: ' + (response && response.data ? response.data : 'Unknown'));
				// 	return;
				// }

				// // Possible shapes we've seen:
				// // 1) response.data.content is an object: { title, sections, article, excerpt }
				// // 2) response.data.content is a JSON string: '{"title":"...","sections":"..."}'
				// // 3) response.data is already the object: { title, sections, ... }
				// // 4) response.data.content is a single string (fallback)

				// var payload = null;

				// // Try shape 1 & 2
				// if (response.data && response.data.content !== undefined) {
				// 	payload = response.data.content;
				// 	// If payload is a string that looks like JSON, try to parse it
				// 	if (typeof payload === 'string') {
				// 		payload = payload.trim();
				// 		try {
				// 			if (payload && (payload.charAt(0) === '{' || payload.charAt(0) === '[')) {
				// 				payload = JSON.parse(payload);
				// 				console.log('Parsed JSON payload from response.data.content');
				// 			} else {
				// 				// it's a plain string (single generated text)
				// 				payload = { article: payload };
				// 			}
				// 		} catch (e) {
				// 			console.warn('Failed to parse response.data.content as JSON:', e, payload);
				// 			payload = { article: payload };
				// 		}
				// 	}
				// } else if (response.data && (response.data.title || response.data.article || response.data.sections)) {
				// 	// shape 3
				// 	payload = response.data;
				// } else {
				// 	// unknown shape: put raw text into article field
				// 	payload = { article: JSON.stringify(response.data) };
				// }

				// // Safe assignment helper: only set if value is present
				// function safeSet(selector, value) {
				// 	var $el = $(selector);
				// 	if ($el.length === 0) {
				// 		console.warn('Element not found for selector:', selector);
				// 		return;
				// 	}
				// 	// Prefer .val for inputs/textarea; fallback to text()
				// 	try {
				// 		$el.val(value == null ? '' : value);
				// 	} catch (err) {
				// 		console.warn('Failed to set value via .val(), trying .text():', err);
				// 		$el.text(value == null ? '' : value);
				// 	}
				// }

				// // Now set fields if present
				// safeSet('#sai_engine_title', payload.title);
				// safeSet('#sai_engine_sections', payload.sections);
				// safeSet('#sai_engine_content', payload.article || payload.content || payload.text);
				// safeSet('#sai_engine_excerpt', payload.excerpt);

				alert('Content generated successfully!');
			},
			error: function () {
				alert('An unexpected error occurred.');
			},
			complete: function () {
				// Re-enable the button
				$('#sai_engine_generate_content_button').prop('disabled', false).text('Generate Content');
			}
		});
	}

	// $('#sai_engine_create_post').on('change', function () {
	// 	var value = $(this).val();
	// 	var key = 'max_length';
	// 	currentSettings( key, value);
	// });

});

//{"success":true,"data":{"content":{"title":"Adventure Sustainably: Reduce Your Footprint, Boost Locals","sections":"## Embark on Ethical Adventures: Travel Responsibly\n## Tread Lightly: Minimizing Your Environmental Footprint\n## Beyond Reduction: Exploring Carbon Offsetting Options\n## Empowering Communities: Supporting Local Economies","article":"===INTRO:\nThe call of the wild, the thrill of discovery, the sheer joy of pushing boundaries \u2013 adventure travel captivates us like few other experiences. But as we explore the world's most pristine landscapes and vibrant cultures, a growing awareness whispers in our ears: how can we do this without leaving a negative mark? The answer lies in sustainable adventure, a philosophy that invites us to not just visit, but to protect, respect, and contribute. This isn't about sacrificing the thrill; it's about enriching it, ensuring that the incredible places we seek out today will remain just as breathtaking for generations to come.\n\nSustainable adventure is a paradigm shift, moving beyond mere tourism to become a conscientious journey. It\u2019s about recognizing our role as temporary stewards of the environments and communities we encounter. This guide will walk you through the actionable steps you can take to embark on truly ethical adventures, significantly reducing your environmental footprint while actively empowering the local people and economies that make these destinations so special. Let's explore how to make every journey a force for good, transforming your passion for adventure into a powerful tool for global betterment.\n\n## Embark on Ethical Adventures: Travel Responsibly\n\nEthical adventure begins with a fundamental shift in perspective: seeing ourselves not just as consumers of experiences, but as active participants in the preservation of our planet\u2019s natural and cultural heritage. This means researching your destination beyond its Instagrammable spots, delving into its environmental vulnerabilities and socio-economic context. Choosing tour operators committed to sustainable practices, understanding local customs and traditions, and ensuring that your presence contributes positively rather than exploiting resources or people are critical first steps. It's about respecting boundaries, whether they are physical (staying on marked trails) or cultural (dressing appropriately, asking permission before photographing individuals).\n\nTrue responsibility also means being mindful of the impact of your choices even before you pack your bags. Opting for accommodations that demonstrate genuine eco-credentials, favoring destinations that are actively managing tourism sustainably, and educating yourself on local issues like water scarcity or wildlife conservation can profoundly shape your trip. It\u2019s about making informed decisions that reflect a deep respect for the places and people you visit, striving to leave behind only positive memories and minimal impact, rather than a legacy of resource depletion or cultural dilution.\n\n## Tread Lightly: Minimizing Your Environmental Footprint\n\nMinimizing your environmental footprint is at the core of sustainable adventure, starting with the methods you choose to reach and navigate your destination. Whenever possible, opt for low-impact travel methods such as public transportation, trains, buses, or even cycling and walking, which not only reduce carbon emissions but also offer a more intimate experience of the local landscape. When flying is unavoidable, choose direct flights to reduce fuel consumption. During your stay, actively conserve resources by turning off lights and air conditioning when leaving your room, taking shorter showers, and being mindful of your water usage, especially in regions facing scarcity. Embrace the \"Leave No Trace\" principles by packing out everything you pack in, properly disposing of waste, and never disturbing wildlife or natural features.\n\nBeyond the major transportation choices, countless smaller actions can significantly reduce your daily impact. Say no to single-use plastics by carrying a reusable water bottle, coffee cup, and shopping bag. Opt for reef-safe sunscreen if you're engaging in water activities. Choose local, seasonal food to reduce food miles and support local agriculture. Be conscious of your purchases, favoring sustainable souvenirs that are locally made and ethically sourced over mass-produced items. Every conscious decision, from your choice of gear to your daily habits on the road, contributes to preserving the natural beauty that drew you to adventure in the first place.\n\n## Beyond Reduction: Exploring Carbon Offsetting Options\n\nWhile diligent reduction of your environmental footprint is paramount, certain aspects of travel, particularly long-distance flights, inevitably generate carbon emissions that are difficult to eliminate entirely. This is where carbon offsetting comes into play, serving as a complementary strategy to mitigate your unavoidable emissions by investing in projects designed to reduce greenhouse gases elsewhere. It's not a license to pollute, but rather a mechanism to support climate action. These projects can range from reforestation and tree planting initiatives that absorb CO2, to renewable energy projects like solar and wind farms that replace fossil fuel reliance, or even community-based energy efficiency programs. Understanding that offsetting is a \"last resort\" after maximizing reduction is key to its ethical application.\n\nWhen considering carbon offsetting, the critical step is to choose reputable and verified programs to ensure your contribution genuinely makes a difference. Look for projects certified by recognized international standards such as the Gold Standard, Verified Carbon Standard (VCS), or the Climate, Community & Biodiversity (CCB) Standards, which guarantee environmental integrity and often provide co-benefits to local communities. Research the specific projects your chosen offset provider supports, ensuring transparency in their operations and a clear demonstration of impact. A responsible approach to offsetting involves educating yourself about the options and selecting those that align with your values, transforming an unavoidable impact into an opportunity to contribute positively to global climate solutions.\n\n## Empowering Communities: Supporting Local Economies\n\nSustainable adventure isn't just about environmental preservation; it's equally about fostering positive social and economic impacts for the people living in the destinations we visit. A powerful way to achieve this is by consciously channeling your financial resources directly into the local economy, ensuring that your travel dollars benefit residents rather than being siphoned off by external corporations. This means choosing locally owned guesthouses, eating at family-run restaurants, hiring local guides for treks or tours, and purchasing authentic handicrafts directly from artisans or fair-trade cooperatives. By doing so, you help create jobs, support small businesses, and contribute to the overall well-being and economic stability of the community, fostering a more equitable distribution of tourism benefits.\n\nBeyond monetary contributions, empowering communities involves meaningful cultural exchange and respecting local livelihoods. Engage respectfully with locals, learn a few phrases of their language, and show genuine interest in their way of life. Participate in community-based tourism initiatives that offer authentic experiences while ensuring that profits directly support local development projects, schools, or conservation efforts. Resist the urge to haggle aggressively, as every cent can make a significant difference. By being a mindful and engaged guest, you not only enrich your own travel experience with deeper connections but also help build a positive relationship between visitors and hosts, paving the way for sustainable and mutually beneficial tourism for years to come.\n\n===OUTRO:\nEmbarking on sustainable adventures is a journey of conscious choices, transforming the act of travel into a powerful force for good. By embracing low-impact methods, actively reducing your environmental footprint, thoughtfully considering carbon offsetting, and wholeheartedly supporting local economies, you elevate your adventures beyond mere sightseeing. You become a responsible global citizen, contributing to the preservation of our planet's natural wonders and the empowerment of its diverse communities. The thrill of discovery can, and should, coexist with a deep sense of stewardship.\n\nEvery decision, from packing your reusable water bottle to choosing a local guide, weaves into a larger tapestry of positive impact. The future of adventure travel depends on us, the explorers, to lead by example. So, as you plan your next escape into the unknown, remember that the most profound adventures are those that leave the world a better place than you found it. Let's adventure sustainably, reduce our footprint, and boost locals, ensuring that the magic of travel endures for all.","excerpt":"Adventure smart: trim your impact, empower local lives."}}}