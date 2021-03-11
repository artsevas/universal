<?php 
  get_header();
?>
<main class="front-page-header">
  <div class="container">
    <div class="hero">
      <div class="left">
        <?php
          global $post;

          $myposts = get_posts([ 
            'numberposts' =>
        1, 'category_name' => 'javascript, css, html, web-design', ]); if(
        $myposts ){ foreach( $myposts as $post ){ setup_postdata( $post ); ?>
        <!-- Выводим записи -->
        <img
          src="<?php the_post_thumbnail_url() ?>"
          alt=""
          class="post-thumb"
        />
        <?php $author_id = get_the_author_meta('ID'); ?>
        <a href="<?php echo get_author_posts_url($author_id) ?>" class="author">
          <img
            src="<?php echo get_avatar_url($author_id) ?>"
            alt=""
            class="avatar"
          />
          <div class="author-bio">
            <span class="author-name"><?php the_author(); ?></span>
            <span class="author-rank">Разработчик</span>
          </div>
        </a>
        <div class="post-text">
          <?php the_category(); ?>
          <h2 class="post-title">
            <?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?>
          </h2>
          <a href="<?php echo get_the_permalink(); ?>" class="more"
            >Читать далее</a
          >
        </div>
        <!-- /.post-text -->
        <?php 
            }
          } else {
            ?>
        <p>Постов нет</p>
        <?php
          }

          wp_reset_postdata(); // Сбрасываем $post
        ?>
      </div>
      <!-- /.left -->
      <div class="right">
        <h3 class="recommend">Рекомендуем</h3>
        <ul class="posts-list">
          <?php
            global $post;

            $myposts = get_posts([ 
              'numberposts' =>
          5, 'offset' => 1, 'category_name' => 'javascript, css, html,
          web-design', ]); if( $myposts ){ foreach( $myposts as $post ){
          setup_postdata( $post ); ?>
          <!-- Выводим записи -->
          <li class="post">
            <?php the_category(); ?>
            <a class="post-permalink" href="<?php echo get_the_permalink(); ?>"
              ><h4 class="post-title">
                <?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?>
              </h4></a
            >
          </li>
          <?php 
            }
          } else {
            ?>
          <p>Постов нет</p>
          <?php
          }

          wp_reset_postdata(); // Сбрасываем $post
        ?>
        </ul>
      </div>
      <!-- /.right -->
    </div>
    <!-- /.hero -->
  </div>
  <!-- /.container -->
</main>
<div class="container">
  <ul class="article-list">
    <?php
      global $post;

      $myposts = get_posts([ 
        'numberposts' =>
    4, 'category_name' => 'articles', ]); if( $myposts ){ foreach( $myposts as
    $post ){ setup_postdata( $post ); ?>
    <!-- Выводим записи -->
    <li class="article-item">
      <a class="article-permalink" href="<?php echo get_the_permalink(); ?>">
        <h4 class="article-title">
          <?php echo mb_strimwidth(get_the_title(), 0, 50, '...') ?>
        </h4>
      </a>
      <img
        width="65px"
        height="65px"
        src="<?php echo get_the_post_thumbnail_url(null, 'thumbnail') ?>"
        alt=""
      />
    </li>
    <?php 
      }
    } else {
    ?>
    <p>Постов нет</p>
    <?php
    }

    wp_reset_postdata(); // Сбрасываем $post
  ?>
  </ul>
  <!-- /.article-list -->
  <div class="main-grid">
    <ul class="article-grid">
      <?php		
        global $post;
  
        $query = new WP_Query( [
          'posts_per_page' =>
      7, ] ); if ( $query->have_posts() ) { $cnt = 0; while (
      $query->have_posts() ) { $query->the_post(); $cnt++; switch ($cnt) { case
      '1': ?>
      <li class="article-grid-item article-grid-item-1">
        <a href="<?php the_permalink()?>" class="article-grid-permalink">
          <span class="category-name">
            <?php $category = get_the_category();
            echo $category[0]->name; ?>
          </span>
          <h4 class="article-grid-title">
            <?php echo get_the_title() ?>
          </h4>
          <p class="article-grid-excerpt">
            <?php echo mb_strimwidth(get_the_excerpt(), 0, 60, '...') ?>
          </p>
          <div class="article-grid-info">
            <div class="author">
              <?php $author_id = get_the_author_meta('ID'); ?>
              <img
                src="<?php echo get_avatar_url($author_id) ?>"
                alt=""
                class="author-avatar"
              />
              <span class="author-name"
                ><strong><?php the_author()?></strong>:
                <?php the_author_meta('description')?></span
              >
            </div>
            <div class="comments">
              <img
                class="icon comments-icon"
                src="<?php echo get_template_directory_uri() . '/assets/images/comment.svg' ?>"
              />
              <span class="comments-counter">
                <?php comments_number('0', '1', '%') ?>
              </span>
            </div>
          </div>
        </a>
      </li>
      <?php
                break;
  
              case '2': ?>
      <li class="article-grid-item article-grid-item-2">
        <img
          src="<?php echo get_the_post_thumbnail_url();?>"
          alt=""
          class="article-grid-thumb"
        />
        <a href="<?php the_permalink()?>" class="article-grid-permalink">
          <span class="tag">
            <?php $posttags = get_the_tags();
            if ( $posttags ) {
              echo $posttags[0]->name . ' '; } ?>
          </span>
          <span class="category-name">
            <?php $category = get_the_category();
            echo $category[0]->name; ?>
          </span>
          <h4 class="article-grid-title">
            <?php echo mb_strimwidth(get_the_title(), 0, 50, '...') ?>
          </h4>
          <div class="article-grid-info">
            <div class="author">
              <?php $author_id = get_the_author_meta('ID'); ?>
              <img
                src="<?php echo get_avatar_url($author_id) ?>"
                alt=""
                class="author-avatar"
              />
              <div class="author-info">
                <span class="author-name"
                  ><strong><?php the_author()?></strong></span
                >
                <span class="date"><?php the_time('j, F') ?></span>
                <div class="comments">
                  <img
                    class="icon comments-icon"
                    src="<?php echo get_template_directory_uri() . '/assets/images/comment.svg' ?>"
                  />
                  <span class="comments-counter">
                    <?php comments_number('0', '1', '%') ?>
                  </span>
                </div>
                <div class="likes">
                  <img
                    src="<?php echo get_template_directory_uri() . '/assets/images/like.svg' ?>"
                    alt="icon: like"
                    class="likes-icon"
                  />
                  <span class="likes-counter"
                    ><?php comments_number('0', '1', '%') ?></span
                  >
                </div>
              </div>
              <!-- /.author-info -->
            </div>
          </div>
        </a>
      </li>
      <?php break;
  
      case '3': ?>
      <li class="article-grid-item article-grid-item-3">
        <a href="<?php the_permalink()?>" class="article-grid-permalink">
          <img
            src="<?php echo get_the_post_thumbnail_url();?>"
            alt=""
            class="article-thumb"
          />
          <h4 class="article-grid-title">
            <?php echo mb_strimwidth(get_the_title(), 0, 50, '...')?>
          </h4>
        </a>
      </li>
      <?php break;
  
              default: ?>
      <li class="article-grid-item article-grid-item-default">
        <a href="<?php the_permalink()?>" class="article-grid-permalink">
          <h4 class="article-grid-title">
            <?php echo mb_strimwidth(get_the_title(), 0, 40, '...')?>
          </h4>
          <p class="article-grid-excerpt">
            <?php echo mb_strimwidth(get_the_excerpt(), 0, 60, '...') ?>
          </p>
          <span class="date"><?php the_time('j, F, Y') ?></span>
        </a>
      </li>
      <?php break;
            }
            ?>
      <?php 
          }
        } else {
        }
  
        wp_reset_postdata(); // Сбрасываем $post
      ?>
    </ul>
    <!-- /.article-grid -->
    <?php get_sidebar(); ?>
  </div>
  <!-- /.main-grid -->
</div>
<!-- /.container -->
