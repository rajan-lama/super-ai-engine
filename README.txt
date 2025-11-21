=== Super AI Engine ===
Contributors: rithemes,lamarajan
Tags: ai, chatbot, gpt, claude, openai
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Believe in Democratize AI with WordPress. Your site can now chat, write poetry, solve problems, etc. with its own intelligent

== Description ==

**Super AI Engine connects WordPress with AI models.** Build intelligent chatbots, generate content, create AI forms, and automate tasks. All from your WordPress dashboard.

Please make sure you read the [disclaimer](https://rithemes.com/super-ai-engine/disclaimer/). For more information, check the official website of [Super AI Engine](https://rithemes.com/wordpress-plugins/super-ai-engine/).

== Quick Intro ==

Hello! ☀️ I built Super AI Engine to bring Gemini and other AI models into WordPress. Create chatbots that understand your content, generate posts in your voice, translate instantly, create images, or build custom AI tools.

For developers: internal APIs, REST endpoints, function calling, and MCP support. Build AI features, automate workflows, or create SaaS applications on WordPress.

Feeling overwhelmed? 🤪 Start simple: Create a chatbot. Then connect ChatGPT through MCP, giving AI direct access to your site. You can even connect Super AI Engine to multiple WordPress sites and manage them all through conversation.

You'll be having a blast before you've explored everything.

== Core Modules ==

🎨 **Content & Images**
Generate content, translate text, create images from prompts, and use Copilot in the WordPress editor for instant suggestions and rewrites.

🔧 **Function Calling**
Connect AI to WordPress functions, WooCommerce, appointments, or custom APIs. Let AI interact with your site's data and services in real-time.

**Content Generation:**

* Generate posts in your voice
* Translate naturally across languages
* Copilot integration in WordPress editor
* Real-time suggestions and rewrites

== 🔧 Developer Tools ==

Extend WordPress with AI capabilities.

**APIs:**

* Internal API for plugin integration
* REST API for external applications
* MCP (Model Context Protocol) support
* Function calling framework

== MCP (Model Context Protocol) ==

Super AI Engine turns your WordPress site into an intelligent MCP server. AI agents like ChatGPT, Gemini, Ollama and Claude can connect directly, browse content, edit posts, manage media, and handle complex tasks through natural conversation.

**What AI Agents Can Do:**

* Create and edit posts
* Moderate comments
* Install and manage plugins
* Customize themes
* Check SEO and analytics
* Manage media files

**Setup Guides:**

* [General MCP Overview](https://ai.thehiddendocs.com/mcp/)
* [MCP with ChatGPT](https://ai.thehiddendocs.com/mcp/mcp-server-chatgpt/)
* [MCP with Claude](https://ai.thehiddendocs.com/mcp/mcp-server-claude/)

**Plugin Integration:**

Super AI Engine can also connect to external MCP servers, extending your chatbots with tools and services beyond WordPress.

== Why Super AI Engine? ==

**Native to WordPress**
Built specifically for WordPress with seamless integration. No clunky interfaces, just native WordPress experience.

**Flexible & Powerful**
Support for multiple AI providers: OpenAI, Anthropic, Google, Hugging Face, and more. Use the models that work best for you.

**Developer Friendly**
Clean APIs, extensive hooks, and MCP support. Build custom AI features or entire SaaS applications on WordPress.

**Privacy First**
IP hashing, GDPR tools, secure file handling, and session-based tracking. You control your data.

**Constantly Evolving**
Weekly updates based on real user feedback. We listen, we improve.

== Installation ==

1. Upload `super-ai-engine` to `/wp-content/plugins/`
2. Activate through the 'Plugins' menu
3. Get an API key from OpenAI (or your preferred AI provider)
4. Add your API key in Settings (Meow Apps > AI Engine)
5. Start creating! 🚀

== Disclaimer ==

Super AI Engine is a plugin that helps you to connect your websites to AI services. You need your own API keys and must follow the rules set by the AI service you choose. For OpenAI, check their [Terms of Service](https://ai.google.dev/gemini-api/terms, https://openai.com/terms/) and [Privacy Policy](https://ai.google.dev/gemini-api/docs/usage-policies, https://openai.com/privacy/). It is also important to check your usage on the [OpenAI website](https://platform.openai.com/usage) for accurate information. Please do so with other services as well.

The developer of AI Engine and related parties are not responsible for any issues or losses caused by using the plugin or AI-generated content. You should talk to a legal expert and follow the laws and regulations of your country. AI Engine does only store data on your own server, and it is your responsibility to keep it safe. AI Engine's full disclaimer is [here](https://rithemes.com/super-ai-engine/disclaimer/).

== Compatibility ==

Please be aware that there may be conflicts with certain caching or performance plugins, such as SiteGround Optimizer and Ninja Firewall. To prevent any issues, ensure that Super AI Engine is excluded from these plugins.

== Frequently Asked Questions ==

= Why am I getting "Error 429: You exceeded your current quota"? =

This error comes from OpenAI's API, not Super AI Engine. Set up billing limits in your [OpenAI account](https://platform.openai.com/account/billing). Caching plugins can sometimes store error responses, so [clear your caches](https://ai.thehiddendocs.com/common-issues/exceeded-current-quota/) too.

= Who is Super AI Engine for, and how do I manage usage limits? =

Super AI Engine can be used by site owners, administrators, and visitors via chat widgets. To set query limits and prevent unlimited model runs, follow the [Managing Limits guide](https://ai.thehiddendocs.com/limits/).

= Does the chatbot support my language? =

AI models support many languages, but quality varies. There's no definitive list since models are constantly updated. [Test your language](https://ai.thehiddendocs.com/faq/does-it-support-my-language) in the AI Playground.

= How does MCP work, and what can I do with it? =

MCP (Model Context Protocol) exposes WordPress tools to AI agents. [Learn how to enable the SSE endpoint](https://ai.thehiddendocs.com/mcp/), choose which tools to expose, and secure them. You can manage posts, comments, users, media, and more.

= Can I restrict the chatbot to answer only from my site content? =

You can't completely block the model's built-in knowledge, but you can [use smart prompts and embeddings](https://ai.thehiddendocs.com/restrict-chatbot-topics/) to steer conversations toward your content.

= The chatbot doesn't appear or looks odd on my site =

Check the [Common Issues guide](https://ai.thehiddendocs.com/common-issues/) for solutions to REST API problems, caching conflicts, nonce errors, and layout glitches.

= Where can I learn the basics and troubleshoot problems? =

Start with the [Basics guide](https://ai.thehiddendocs.com/basics/) for installation and key concepts. For specific issues, check [Common Issues](https://ai.thehiddendocs.com/common-issues/).

= How do I report security issues? =

Report security vulnerabilities through the [Patchstack Vulnerability Disclosure Program](https://patchstack.com/database/vdp/9e5fbbbc-964a-4204-8bc0-198f21284efd).

== Changelog ==

= 1.0.0 =
* Initial Release 