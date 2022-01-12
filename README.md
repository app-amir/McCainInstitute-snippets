# McCainInstitute-snippets

# WordPress Theme for https://www.McCainInstitute.org/ - McCain

**WordPress Version:** 5.7

**Lead:** AMIR SOHAIL

**Data Entry:** Junior Team

**Front-End Team:** Dedicated Team

**Back-End Team:** AMIR SOHAIL

**QA:** Junior Team

**Description:** McCain is the child theme of hello-elementor.

This theme is created to customize WordPress and fulfill the Project requirements. In this theme, we've created custom shortcodes, pagination, and templates for the theme.

## Dependencies ##
* Elementor (Free and Pro, primary template builder)
* DynamicConditions (Show/Hide Elementor widgets)
* McCain Functionality Plugin (used for [CPT] management)
* ACF Pro (used extensively)
* Gravity Forms (primary form builder)
* Safe SVG (Enable svg mime type for media)

## Registered Shortcode's ##

| Shortcode's | Description |
| ----------- | ----------- |
| mccain_events | Fetching the ACF fields data and display events only from today and in the future. |
| mccain_quotes | Display McCain Quotes in footer. |
| mccain_archive_slider | Used in slider and called on the resources page. |
| mccain_program_slider | Used in slider and called on the single program page. ( Param: `tag` => fetching posts tag wise. ) |
| mccain_feature_blog | Displaying `feature` tag posts on homepage. |
| mccain_event_archive | Fetching the ACF fields data and display events only from today and in the future on event archive page. |
| mccain_current_year | get current year, used in footer. |
| mccain_default_archive | Create a structure for archive pages. ( Used `pre_get_posts` for setting the query args. ) |
| mccain_on_the_issue | Create a structure for `on-the-issue` category archive pages. |
| mccain_report_archive_filter | Create a structure for filter, used on reports archive. |
| mccain_podcast_archive_filter | Create a structure for filter, used on podcast archive. |
| mccain_event_archive_filter | Create a structure for filter, used on events archive. |
| mccain_issue_category_archive_filter | Create a structure for filter, used on the issue category archive. |
| mccain_featured_issue | Used in slider and called on the issues page. |
| mccain_staff_block | Fetch the Staff posts with ACF data and display them on the staff page. |
| mccain_ngl_block | Fetch the NGL posts with ACF data and display them on the leadership page. |


## Custom Templates ##
* No Custom Template.

## CPT's - (Inside the Plugin) ##

| CPT Name | Registered Name | Slug |
| ----------- | ----------- | ----------- |
| McCain Podcast | mccain-podcast | resources/podcast |
| McCain Reports | mccain-report | resources/reports |
| McCain Events | mccain-event | resources/events |
| McCain Quotes | mccain-quote | quotes |

## Custom Taxonomies - (Inside the Plugin) ##

| Taxonomy Name | Registered Name | Slug |
| ----------- | ----------- | ----------- |
| McCain Post Terms | mccain-term | term |
| McCain Event Tags | mccain-event-tags | tags |
| McCain Report Types | mccain-report-type | report-types |
| McCain Podcast Types | mccain-podcast-term | podcast-term |
| McCain Quote Types | mccain-quote-type | types |

## Images Sizes ##
Registered by WordPress:
* thumbnail: 150x150
* medium: 300x300
* medium_large: 768px x no height limit max
* large: 1024x1024
* full: Original image resolution (unmodified)
