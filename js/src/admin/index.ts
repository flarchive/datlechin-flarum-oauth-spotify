import app from 'flarum/admin/app';
import { ConfigureWithOAuthPage } from '@fof-oauth';

app.initializers.add('datlechin/flarum-oauth-spotify', () => {
  app.extensionData.for('datlechin-oauth-envato').registerPage(ConfigureWithOAuthPage);
});
